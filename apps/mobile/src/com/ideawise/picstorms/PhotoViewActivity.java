package com.ideawise.picstorms;

import org.json.simple.JSONArray;
import org.json.simple.JSONObject;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.preference.PreferenceManager;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import com.ideawise.picstorms.beans.Theme;
import com.ideawise.picstorms.perferences.Preferences;
import com.ideawise.picstorms.shared.Server;

public class PhotoViewActivity extends CameraActivity {
	private ImageButton backButton = null;

	private ImageLoader imageLoader = null;

	private ViewGroup vg = null;

	Button registerButtonClick;
	Button loginButtonClick;
	Button likeButton;

	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);

		LayoutInflater layoutInflater = (LayoutInflater) this
				.getSystemService(Context.LAYOUT_INFLATER_SERVICE);

		if (Preferences.isLogin(PhotoViewActivity.this)) {
			vg = (ViewGroup) layoutInflater.inflate(
					R.layout.photo_view_activity_login, null);
		} else {
			vg = (ViewGroup) layoutInflater.inflate(
					R.layout.photo_view_activity_logout, null);
		}

		setContentView(vg);

		if (Preferences.isLogin(PhotoViewActivity.this)) {
			addLikeButton();
		} else {
			addLogoutLiseners();
		}

		addListeners();

		Bundle bundle = this.getIntent().getExtras();
		String url = bundle.getString("url");
		String title = bundle.getString("title");
		// store current photo title in memory
		Preferences.set(
				PreferenceManager.getDefaultSharedPreferences(
						PhotoViewActivity.this).edit(),
				Preferences.CURRENT_PHOTO_TITLE, title);

		imageLoader = new ImageLoader(this.getApplicationContext());
		ImageView image = (ImageView) findViewById(R.id.big_photo);
		imageLoader.DisplayImage(url, this, image);

		initPerference();
		
		if (Preferences.isLogin(PhotoViewActivity.this)) {
			browse();	
		}
		

	}

	public void browse() {
		RestClient client = new RestClient(Server.getPhotoViewUrl());
		try {
			client.AddParam("userId", Preferences.get(PreferenceManager
					.getDefaultSharedPreferences(PhotoViewActivity.this),
					Preferences.PREFERENCE_USER_ID));
			client.AddParam("photoTitle", Preferences.get(PreferenceManager
					.getDefaultSharedPreferences(PhotoViewActivity.this),
					Preferences.CURRENT_PHOTO_TITLE));
			// the actual call here
			client.Execute(RequestMethod.POST, ResponseType.JSON_OBJECT);
		} catch (Exception e) {
			e.printStackTrace();
		}

		// retrieving the response of the call
		Object response = client.getResponse();
		JSONObject jsonObj = (JSONObject) response;
		Button b = (Button) findViewById(R.id.likeButton);
		String count = jsonObj.get("count").toString();
		
//		int photoId = (Integer) jsonObj.get("id");
		Preferences.set(
				PreferenceManager.getDefaultSharedPreferences(
						PhotoViewActivity.this).edit(),
				Preferences.CURRENT_PHOTO_COUNT, String.valueOf(count));

		if ("1".equals((String) jsonObj.get("s"))) {
			b.setText("+" + count + " I like it!");
		} else {
			b.setText("+" + count + " Like");
			b.setEnabled(false);
		}

	}

	private void addLikeButton() {
		likeButton = (Button) findViewById(R.id.likeButton);
		likeButton.setOnClickListener(new OnClickListener() {
			public void onClick(View v) {
				like();
			}
		});

	}

	private void addListeners() {

		backButton = (ImageButton) findViewById(R.id.backButton);
		backButton.setOnClickListener(new OnClickListener() {
			public void onClick(View v) {
				setVisible(false);
				Intent intent = new Intent(PhotoViewActivity.this,
						PicstormsActivity.class);
				intent.setAction(Intent.ACTION_MAIN);
				intent.setFlags(Intent.FLAG_ACTIVITY_NO_HISTORY
						| Intent.FLAG_ACTIVITY_EXCLUDE_FROM_RECENTS
						| Intent.FLAG_ACTIVITY_CLEAR_TOP);
				startActivity(intent);
				finish();
			}
		});
	}

	/**
	 * Init remote urls; Init current theme
	 */
	private void initPerference() {
		Theme theme = Picstorms.getCurrentTheme();
		TextView t = (TextView) findViewById(R.id.photoDetailViewHeader);
		t.setText(theme.getTitle());
	}

	// @Override
	// public boolean onKeyDown(int keyCode, KeyEvent event) {
	// if (keyCode == KeyEvent.KEYCODE_BACK) {
	// setVisible(false);
	// Intent intent = new Intent(PhotoViewActivity.this,
	// PicstormsActivity.class);
	// intent.setAction(Intent.ACTION_MAIN);
	// intent.setFlags(Intent.FLAG_ACTIVITY_NO_HISTORY
	// | Intent.FLAG_ACTIVITY_EXCLUDE_FROM_RECENTS
	// | Intent.FLAG_ACTIVITY_CLEAR_TOP);
	// startActivity(intent);
	// finish();
	// return true;
	// }
	// return super.onKeyDown(keyCode, event);
	// }
	//
	// public Object fetch(String address) throws MalformedURLException,
	// IOException {
	// URL url = new URL(address);
	// Object content = url.getContent();
	// return content;
	// }

	@Override
	public void onActivityResult(int requestCode, int resultCode, Intent data) {
		super.onActivityResult(requestCode, resultCode, data);

		if (requestCode == REQUEST_CODE && resultCode == Activity.RESULT_OK) {
			setVisible(false);
			Intent intent = new Intent(PhotoViewActivity.this,
					PicstormsActivity.class);
			intent.setAction(Intent.ACTION_MAIN);
			intent.setFlags(Intent.FLAG_ACTIVITY_NO_HISTORY
					| Intent.FLAG_ACTIVITY_EXCLUDE_FROM_RECENTS
					| Intent.FLAG_ACTIVITY_CLEAR_TOP);
			startActivity(intent);
			finish();
		}
	}

	public void like() {
		RestClient client = new RestClient(Server.getLikeUrl());
		try {
			client.AddParam("userId", Preferences.get(PreferenceManager
					.getDefaultSharedPreferences(PhotoViewActivity.this),
					Preferences.PREFERENCE_USER_ID));
			client.AddParam("photoTitle", Preferences.get(PreferenceManager
					.getDefaultSharedPreferences(PhotoViewActivity.this),
					Preferences.CURRENT_PHOTO_TITLE));
			// the actual call here
			client.Execute(RequestMethod.POST, ResponseType.JSON_OBJECT);
		} catch (Exception e) {
			e.printStackTrace();
		}

		// retrieving the response of the call
		Object response = client.getResponse();
		JSONObject jsonObj = (JSONObject) response;
		if ("1".equals((String) jsonObj.get("s"))) {
			Toast.makeText(this, getString(R.string.you_like_it_successfully),
					Toast.LENGTH_LONG).show();
			Button b = (Button) findViewById(R.id.likeButton);
			String oldCount = Preferences.get(PreferenceManager
					.getDefaultSharedPreferences(PhotoViewActivity.this),
					Preferences.CURRENT_PHOTO_COUNT);
			b.setText("+"+(Integer.valueOf(oldCount)+1)+" Like");
			b.setEnabled(false);
		} else {
			Toast.makeText(this,
					getString(R.string.you_like_it_unsuccessfully),
					Toast.LENGTH_LONG).show();
		}

	}
}
