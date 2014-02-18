package com.ideawise.picstorms;

import java.io.File;

import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Intent;
import android.content.SharedPreferences.Editor;
import android.net.Uri;
import android.os.AsyncTask;
import android.os.Bundle;
import android.os.Environment;
import android.preference.PreferenceManager;
import android.provider.MediaStore;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.View.OnClickListener;
import android.webkit.MimeTypeMap;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.Button;
import android.widget.GridView;
import android.widget.ImageButton;
import android.widget.Toast;

import com.google.android.apps.analytics.GoogleAnalyticsTracker;
import com.ideawise.picstorms.perferences.Preferences;
import com.ideawise.picstorms.shared.PhotoSource;
import com.ideawise.picstorms.shared.Server;

public class CameraActivity extends Activity {
	protected static Uri imageUri;
	protected UploadClient uploadClient = null;

	protected ImageButton cameraButton;

	protected GridView gridview;

	protected String[] urls = null;

	protected LazyAdapter adapter;
	
	private ProgressDialog mProgressDialog;

	protected Button logoutButton;
	protected Button registerButtonClick;
	protected Button loginButtonClick;

	protected static final int MENU_LOGOUT = 100;
	protected static final int MENU_LOGIN = 101;

	protected static final int REQUEST_CODE = 1;
	

	
	GoogleAnalyticsTracker tracker;
	
	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);

		tracker = GoogleAnalyticsTracker.getInstance();

	    // Start the tracker in manual dispatch mode...
	    tracker.startNewSession("UA-9434024-5", this);
	}
	
	@Override
	public void onActivityResult(int requestCode, int resultCode, Intent data) {
		super.onActivityResult(requestCode, resultCode, data);
		if (requestCode == REQUEST_CODE && resultCode == Activity.RESULT_OK) {
			new UploadTask().execute();
			tracker.trackPageView("/uploadPhotoSuccess");
		}
	}

	protected void addPhotoItemListener() {
		this.urls = PhotoSource.getThumbnailUrls(false);

		gridview = (GridView) findViewById(R.id.gridview);
		adapter = new LazyAdapter(this, this.urls);
		gridview.setAdapter(adapter);

		gridview.setOnItemClickListener(new OnItemClickListener() {
			public void onItemClick(AdapterView<?> parent, View v,
					int position, long id) {
				setVisible(false);

				Bundle bundle = new Bundle();
				String urls[] = PhotoSource.getBigSizeUrls(false);
				String titles[] = PhotoSource.getTitles(false);
				bundle.putString("url", urls[position]);
				bundle.putString("title", titles[position]);

				Intent intent = new Intent(CameraActivity.this,
						PhotoViewActivity.class);
				intent.putExtras(bundle);

				intent.setAction(Intent.ACTION_MAIN);
				intent.setFlags(Intent.FLAG_ACTIVITY_NO_HISTORY
						| Intent.FLAG_ACTIVITY_EXCLUDE_FROM_RECENTS
						| Intent.FLAG_ACTIVITY_CLEAR_TOP);
				startActivity(intent);
				finish();
			}
		});
	}

	protected void addCameraButton() {
		cameraButton = (ImageButton) findViewById(R.id.cameraButton);
		cameraButton.setOnClickListener(new OnClickListener() {
			public void onClick(View v) {
				tracker.trackEvent(
			            "clicks",  // Category
			            "cameraButton",  // Action
			            "clicked", // Label
			            1);   
				
				/**
				 * If user is not login, will redirect user to login firstly.
				 */

				if (!Preferences.isLogin(CameraActivity.this)) {
					System.out
							.println("Redirect to login windown from camera button.....");
					setVisible(false);
					Intent intent = new Intent(CameraActivity.this,
							LoginActivity.class);
					intent.setAction(Intent.ACTION_MAIN);
					intent.setFlags(Intent.FLAG_ACTIVITY_NO_HISTORY
							| Intent.FLAG_ACTIVITY_EXCLUDE_FROM_RECENTS
							| Intent.FLAG_ACTIVITY_CLEAR_TOP);
					startActivity(intent);
					finish();
				} else {
					/**
					 * If user has logined, start
					 * android.media.action.IMAGE_CAPTURE intent
					 */
					Intent intent = new Intent(
							"android.media.action.IMAGE_CAPTURE");
					File photo = new File(Environment
							.getExternalStorageDirectory(), "Pic.jpg");
					intent.putExtra(MediaStore.EXTRA_OUTPUT,
							Uri.fromFile(photo));
					imageUri = Uri.fromFile(photo);
					startActivityForResult(intent, REQUEST_CODE);
				}

			}
		});
	}

	protected void addLogoutLiseners() {
		registerButtonClick = (Button) findViewById(R.id.register_button);
		registerButtonClick.setOnClickListener(new OnClickListener() {
			public void onClick(View v) {
				setVisible(false);
				String url = Server.getSingupUrl();
				Intent i = new Intent(Intent.ACTION_VIEW);
				i.setData(Uri.parse(url));
				startActivity(i);
				finish();
			}
		});

		loginButtonClick = (Button) findViewById(R.id.login_button);
		loginButtonClick.setOnClickListener(new OnClickListener() {
			public void onClick(View v) {
				setVisible(false);
				Intent intent = new Intent(CameraActivity.this,
						LoginActivity.class);
				intent.setAction(Intent.ACTION_MAIN);
				intent.setFlags(Intent.FLAG_ACTIVITY_NO_HISTORY
						| Intent.FLAG_ACTIVITY_EXCLUDE_FROM_RECENTS
						| Intent.FLAG_ACTIVITY_CLEAR_TOP);
				startActivity(intent);
				finish();
			}
		});
	}

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		String userName = Preferences.get(PreferenceManager
				.getDefaultSharedPreferences(CameraActivity.this),
				Preferences.PREFERENCE_LOGIN);

		if (null != userName) {
			menu.add(0, MENU_LOGOUT, 0, "Logout");
		} else {
			menu.add(0, MENU_LOGIN, 0, "Login");
		}

		return true;
	}

	@Override
	public boolean onOptionsItemSelected(MenuItem item) {
		switch (item.getItemId()) {
		case MENU_LOGOUT:
			Toast.makeText(this, R.string.you_are_logout, Toast.LENGTH_LONG)
					.show();

			Editor editor = PreferenceManager.getDefaultSharedPreferences(
					CameraActivity.this).edit();
			Server server = new Server();
			Preferences.logoutUser(server, editor);

			break;
		case MENU_LOGIN:
			setVisible(false);
			Intent intent = new Intent(CameraActivity.this, LoginActivity.class);
			intent.setAction(Intent.ACTION_MAIN);
			intent.setFlags(Intent.FLAG_ACTIVITY_NO_HISTORY
					| Intent.FLAG_ACTIVITY_EXCLUDE_FROM_RECENTS
					| Intent.FLAG_ACTIVITY_CLEAR_TOP);
			startActivity(intent);
			finish();
			break;
		}
		return true;
	}
	
	private ProgressDialog showProgressDialog() {
		if (mProgressDialog == null) {
			ProgressDialog dialog = new ProgressDialog(this);
			dialog.setTitle(R.string.upload_photo_dialog_title);
			dialog.setMessage(getString(R.string.upload_photo_dialog_message));
			dialog.setIndeterminate(true);
			dialog.setCancelable(false);
			mProgressDialog = dialog;
		}
		mProgressDialog.show();
		return mProgressDialog;
	}
	
	private void dismissProgressDialog() {
		try {
			mProgressDialog.dismiss();
		} catch (IllegalArgumentException e) {
			// We don't mind. android cleared it for us.
		}
	}
	
	private class UploadTask extends AsyncTask<Void, Void, Boolean> {
		@Override
		protected void onPreExecute() {
			showProgressDialog();
		}
		
		@Override
		protected Boolean doInBackground(Void... params) {
			Uri uri = imageUri;
			String path = uri.getPath();
			
			uploadClient = new UploadClient(Server.getUploadUrl(), 
					new File(path), MimeTypeMap.getFileExtensionFromUrl(path));
			uploadClient.upload(PreferenceManager
					.getDefaultSharedPreferences(CameraActivity.this));
			return true;
		}
		
		@Override
		protected void onPostExecute(Boolean loggedIn) {
			dismissProgressDialog();
			LazyAdapter adapter = ((LazyAdapter) gridview.getAdapter());
			adapter.imageLoader.clearCache();
			adapter.setData(PhotoSource.getThumbnailUrls(true));
			gridview.setAdapter(adapter);
		}
	}
}
