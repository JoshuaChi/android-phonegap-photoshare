package com.ideawise.picstorms;

import org.json.simple.JSONObject;

import com.ideawise.picstorms.beans.Theme;
import com.ideawise.picstorms.shared.Server;

import android.app.Application;

public class Picstorms extends Application {
	public static final String INTENT_ACTION_LOGGED_OUT = "com.ideawise.picstorms.intent.action.LOGGED_OUT";
	public static final String INTENT_ACTION_LOGGED_IN = "com.ideawise.picstorms.intent.action.LOGGED_IN";
	public static final String EXTRA_VENUE_ID = "com.ideawise.picstorms.VENUE_ID";


	public static Theme getCurrentTheme() {
		RestClient client = new RestClient(Server.getRequestCurrentThemeUrl());
		try {
			// the actual call here
			client.Execute(RequestMethod.POST, ResponseType.JSON_OBJECT);
		} catch (Exception e) {
			e.printStackTrace();
		}

		Object response = client.getResponse();
		JSONObject jsonObj = (JSONObject) response;
		System.out.println(jsonObj.get("t"));
		Theme theme = new Theme();
		theme.setId((String) jsonObj.get("id"));
		theme.setTitle((String) jsonObj.get("t"));
		theme.setDesc((String) jsonObj.get("d"));
		theme.setCreated((String) jsonObj.get("c"));
		theme.setCurrentPhotoNumers((String) jsonObj.get("n"));

		return theme;
	}
}
