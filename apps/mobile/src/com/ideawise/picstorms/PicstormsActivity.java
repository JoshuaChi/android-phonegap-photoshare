package com.ideawise.picstorms;

import android.app.Activity;
import android.app.AlertDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.net.wifi.WifiInfo;
import android.net.wifi.WifiManager;
import android.os.Bundle;
import android.preference.PreferenceManager;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.PopupWindow;
import android.widget.TextView;

import com.ideawise.picstorms.beans.Theme;
import com.ideawise.picstorms.perferences.Preferences;
import com.ideawise.picstorms.shared.PhotoSource;

public class PicstormsActivity extends CameraActivity {
	static final int DIALOG_ABOUT = 1;

	View popupView = null;
	Button loginButton = null;
	PopupWindow mPopupWindow = null;

	private ViewGroup vg = null;
	
	@Override
	public void onActivityResult(int requestCode, int resultCode, Intent data) {
		super.onActivityResult(requestCode, resultCode, data);
		
		if (requestCode == REQUEST_CODE && resultCode == Activity.RESULT_OK) {
			urls = PhotoSource.getThumbnailUrls(true);
			adapter = new LazyAdapter(this, urls);
			gridview.setAdapter(adapter);
		}
	}

	/** Called when the activity is first created. */
	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);

		LayoutInflater layoutInflater = (LayoutInflater) this
				.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
		
		ValidateWifi validate = new ValidateWifi(this);
		if(validate.canUseWifi())
		{
			if (Preferences.isLogin(PicstormsActivity.this)) {
				vg = (ViewGroup) layoutInflater.inflate(R.layout.main_login, null);
			} else {
				vg = (ViewGroup) layoutInflater.inflate(R.layout.main_logout, null);

			}
			setContentView(vg);

			if (Preferences.isLogin(PicstormsActivity.this)) {
				addCameraButton();
			} else {
				addLogoutLiseners();
			}
			addPhotoItemListener();

			initPerference();
		}
		else
		{
			AlertDialog.Builder builder = new AlertDialog.Builder(this);
			final View textEntryView = layoutInflater.inflate(R.layout.dialog, null);
			builder.setMessage(R.string.need_wifi)
			       .setCancelable(false)
			       .setView(textEntryView)
			       .setNeutralButton(((CharSequence)"Ok"), new DialogInterface.OnClickListener(){
			    	   public void onClick(DialogInterface dialog, int id){
			    		   PicstormsActivity.this.finish();
			    	   }
			       });
			AlertDialog alert = builder.create();
			alert.show();
		}


	}

	/**
	 * Init remote urls; Init current theme
	 */
	private void initPerference() {
		Theme theme = Picstorms.getCurrentTheme();
		Preferences.set(
				PreferenceManager.getDefaultSharedPreferences(
						PicstormsActivity.this).edit(),
				Preferences.CURRENT_THEME_ID, theme.getId());

		Preferences.set(
				PreferenceManager.getDefaultSharedPreferences(
						PicstormsActivity.this).edit(),
				Preferences.CURRENT_THEME_TITLE, theme.getTitle());

		Preferences.set(
				PreferenceManager.getDefaultSharedPreferences(
						PicstormsActivity.this).edit(),
				Preferences.CURRENT_THEME_DESC, theme.getDesc());

		TextView t = (TextView) findViewById(R.id.theme);
		t.setText(theme.getTitle());

	}

	@Override
	public void onDestroy() {
		if(gridview != null)
		{
		   gridview.setAdapter(null);
		}

		super.onDestroy();
	}
}