package com.ideawise.picstorms.perferences;

import java.io.IOException;
import java.util.UUID;

import org.json.simple.JSONObject;

import android.app.Activity;
import android.content.SharedPreferences;
import android.content.SharedPreferences.Editor;
import android.preference.PreferenceManager;

import com.ideawise.picstorms.RequestMethod;
import com.ideawise.picstorms.ResponseType;
import com.ideawise.picstorms.RestClient;
import com.ideawise.picstorms.beans.Settings;
import com.ideawise.picstorms.beans.User;
import com.ideawise.picstorms.shared.Server;

public class Preferences {
	public static final String TAG = "Preferences";

	//theme
	public static final String CURRENT_THEME_ID = "current_theme_id";
	public static final String CURRENT_THEME_TITLE = "current_theme_title";
	public static final String CURRENT_THEME_DESC = "current_theme_desc";

	// Visible Preferences (sync with preferences.xml)
	public static final String PREFERENCE_TWITTER_CHECKIN = "twitter_checkin";
	public static final String PREFERENCE_SHARE_CHECKIN = "share_checkin";
	public static final String PREFERENCE_IMMEDIATE_CHECKIN = "immediate_checkin";

	// Hacks for preference activity extra UI elements.
	public static final String PREFERENCE_FRIEND_REQUESTS = "friend_requests";
	public static final String PREFERENCE_FRIEND_ADD = "friend_add";
	public static final String PREFERENCE_CITY_NAME = "city_name";
	public static final String PREFERENCE_LOGOUT = "logout";

	// Credentials related preferences
	public static final String PREFERENCE_LOGIN = "login";
	public static final String PREFERENCE_PASSWORD = "password";
	public static final String PREFERENCE_OAUTH_TOKEN = "oauth_token";
	public static final String PREFERENCE_OAUTH_TOKEN_SECRET = "oauth_token_secret";

	//Current photo title
	public static final String CURRENT_PHOTO_TITLE = "current_photo_title";
	
	// Extra info for getUser
	public static final String PREFERENCE_USER_ID = "id";
	public static final String PREFERENCE_EMAIL = "email";

	// Not-in-XML preferences for dumpcatcher
	public static final String PREFERENCE_DUMPCATCHER_CLIENT = "dumpcatcher_client";

	public static final String CURRENT_PHOTO_ID = "current_photo_id";

	public static final String CURRENT_PHOTO_COUNT = "current_photo_count";

	public static String createUniqueId(SharedPreferences preferences) {
		String uniqueId = preferences.getString(PREFERENCE_DUMPCATCHER_CLIENT,
				null);
		if (uniqueId == null) {
			uniqueId = UUID.randomUUID().toString();
			Editor editor = preferences.edit();
			editor.putString(PREFERENCE_DUMPCATCHER_CLIENT, uniqueId);
			editor.commit();
		}
		return uniqueId;
	}

	public static User loginUser(Server server, String login, String password,
			Editor editor) throws IOException {

		server.setCredentials(login, password);
		storeLoginAndPassword(editor, login, password);
		editor.commit();

		User user = new User();

		RestClient client = new RestClient(Server.getLoginUrl());
		client.AddParam("m", "1");
		client.AddParam("name", login);
		client.AddParam("password", password);
		try {
			// the actual call here
			client.Execute(RequestMethod.POST, ResponseType.JSON_OBJECT);
		} catch (Exception e) {
			e.printStackTrace();
		}

		// retrieving the response of the call
		Object response = client.getResponse();
		JSONObject jsonObj = (JSONObject) response;
		System.out.println(jsonObj.get("name"));
		user.setId((String) jsonObj.get("id"));
		user.setName((String) jsonObj.get("name"));
		user.setEmail((String) jsonObj.get("email"));
		user.setCreated((String) jsonObj.get("created_at"));
		user.setLoginCount((String) jsonObj.get("login_count"));

		storeUser(editor, user);
		editor.commit();

		return user;
	}

	/**
	 * Clear session
	 * 
	 * @param server
	 * @param editor
	 * @return
	 */
	public static boolean logoutUser(Server server, Editor editor) {

		// TODO: If we re-implement oAuth, we'll have to call
		// clearAllCrendentials here.
		server.setCredentials(null, null);
		return editor.clear().commit();
	}

	public static User getUser(SharedPreferences prefs) {

		Settings settings = new Settings();
		settings.setSendtotwitter(prefs.getBoolean(PREFERENCE_TWITTER_CHECKIN,
				false));

		User user = new User();
		user.setId(prefs.getString(PREFERENCE_USER_ID, null));
		user.setName(prefs.getString(PREFERENCE_LOGIN, null));
		user.setEmail(prefs.getString(PREFERENCE_EMAIL, null));
		user.setSettings(settings);

		return user;
	}

	/**
	 * Store session
	 * 
	 * @param editor
	 * @param login
	 * @param password
	 */
	public static void storeLoginAndPassword(final Editor editor, String login,
			String password) {
		editor.putString(PREFERENCE_LOGIN, login);
		editor.putString(PREFERENCE_PASSWORD, password);
	}

	public static void storeUser(final Editor editor, User user) {
		if (user != null && user.getId() != null) {
			editor.putString(PREFERENCE_USER_ID, user.getId());
		} else {

		}
	}

	/**
	 * 
	 * @param editor
	 * @param key
	 * @param value
	 */
	public static void set(Editor editor, String key, String value) {
		editor.putString(key, value);
		editor.commit();
	}

	/**
	 * 
	 * @param settings
	 * @param key
	 * @return
	 */
	public static String get(SharedPreferences settings, String key) {
		return settings.getString(key, null);
	}
	
	


	public static boolean isLogin(Activity a) {
		SharedPreferences settings = PreferenceManager
				.getDefaultSharedPreferences(a);
		String userName = settings
				.getString(Preferences.PREFERENCE_LOGIN, null);
		if (null == userName) {
			return false;
		} else {
			return true;
		}
	}

}