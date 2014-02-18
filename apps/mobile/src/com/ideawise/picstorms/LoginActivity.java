package com.ideawise.picstorms;

import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Intent;
import android.content.SharedPreferences.Editor;
import android.net.Uri;
import android.os.AsyncTask;
import android.os.Bundle;
import android.preference.PreferenceManager;
import android.text.Editable;
import android.text.TextUtils;
import android.text.TextWatcher;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import com.ideawise.picstorms.beans.User;
import com.ideawise.picstorms.perferences.Preferences;
import com.ideawise.picstorms.shared.Server;

public class LoginActivity extends Activity {

	private ProgressDialog mProgressDialog;
	private EditText mUsernameEditText;
	private EditText mPasswordEditText;
	private AsyncTask<Void, Void, Boolean> mLoginTask;

	private TextView mNewAccountTextView;
	
	UploadClient uploadClient = null;

	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		// super.loadUrl("file:///android_asset/www/index.html");
		setContentView(R.layout.login_activity);
		setupUI();

		// Re-task if the request was cancelled.
		mLoginTask = (LoginTask) getLastNonConfigurationInstance();
		if (mLoginTask != null && mLoginTask.isCancelled()) {
			mLoginTask = new LoginTask().execute();
		}
	}

	private void setupUI() {
		final Button button = (Button) findViewById(R.id.login_button);
		button.setOnClickListener(new OnClickListener() {
			public void onClick(View v) {
				mLoginTask = new LoginTask().execute();
			}
		});

		mNewAccountTextView = (TextView)findViewById(R.id.newAccountTextView);
        mNewAccountTextView.setOnClickListener(new OnClickListener() {
            public void onClick(View v) {
                startActivity(new Intent( //
                        Intent.ACTION_VIEW, Uri.parse(Server.getSingupUrl())));
            }
        });
        
		mUsernameEditText = ((EditText) findViewById(R.id.userNameEditText));
		mPasswordEditText = ((EditText) findViewById(R.id.passwordEditText));

		TextWatcher fieldValidatorTextWatcher = new TextWatcher() {
			public void afterTextChanged(Editable s) {
			}

			public void beforeTextChanged(CharSequence s, int start, int count,
					int after) {
			}

			public void onTextChanged(CharSequence s, int start, int before,
					int count) {
				button.setEnabled(userNameEditTextFieldIsValid()
						&& passwordEditTextFieldIsValid());
			}

			private boolean userNameEditTextFieldIsValid() {
				return !TextUtils.isEmpty(mUsernameEditText.getText());
			}

			private boolean passwordEditTextFieldIsValid() {
				return !TextUtils.isEmpty(mPasswordEditText.getText());
			}
		};

		mUsernameEditText.addTextChangedListener(fieldValidatorTextWatcher);
		mPasswordEditText.addTextChangedListener(fieldValidatorTextWatcher);

	}

	private ProgressDialog showProgressDialog() {
		if (mProgressDialog == null) {
			ProgressDialog dialog = new ProgressDialog(this);
			dialog.setTitle(R.string.login_dialog_title);
			dialog.setMessage(getString(R.string.login_dialog_message));
			dialog.setIndeterminate(true);
			dialog.setCancelable(true);
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

	private class LoginTask extends AsyncTask<Void, Void, Boolean> {
		private static final String TAG = "LoginTask";

		private Exception mReason;

		@Override
		protected void onPreExecute() {
			showProgressDialog();
		}

		@Override
		protected Boolean doInBackground(Void... params) {
			Editor editor = PreferenceManager.getDefaultSharedPreferences(
					LoginActivity.this).edit();
			Server server = new Server();
			try {
				String userName = mUsernameEditText.getText().toString();
				String password = mPasswordEditText.getText().toString();

				User user = Preferences.loginUser(server, userName, password,
						editor);

				if (user != null && !TextUtils.isEmpty(user.getId())) {
					System.out.println("Should work now!!!!!!");
					return true;
				}

			} catch (Exception e) {
				mReason = e;
				System.out.println("Wrong, Wrong, Wrong, Wrong, Wrong!!!!!!"
						+ mReason);
			}

			Preferences.logoutUser(server, editor);

			return false;
		}

		@Override
		protected void onPostExecute(Boolean loggedIn) {
			if (loggedIn) {
				sendBroadcast(new Intent(Picstorms.INTENT_ACTION_LOGGED_IN));
				Toast.makeText(LoginActivity.this,
						getString(R.string.now_you_can_take_a_photo),
						Toast.LENGTH_LONG).show();
				Intent intent = new Intent(LoginActivity.this,
						PicstormsActivity.class);
				intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
				startActivity(intent);
				finish();

			} else {
				sendBroadcast(new Intent(Picstorms.INTENT_ACTION_LOGGED_OUT));
				Toast.makeText(LoginActivity.this,
						R.string.login_failed_login_toast, Toast.LENGTH_LONG)
						.show();
			}
			dismissProgressDialog();
		}

		@Override
		protected void onCancelled() {
			dismissProgressDialog();
		}
	}
}
