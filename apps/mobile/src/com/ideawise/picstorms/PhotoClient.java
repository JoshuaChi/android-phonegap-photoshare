package com.ideawise.picstorms;

import java.io.IOException;
import java.io.UnsupportedEncodingException;
import java.util.ArrayList;
import java.util.List;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.HttpVersion;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.HttpClient;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.entity.mime.MultipartEntity;
import org.apache.http.entity.mime.content.ContentBody;
import org.apache.http.entity.mime.content.FileBody;
import org.apache.http.entity.mime.content.StringBody;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.params.CoreProtocolPNames;
import org.apache.http.util.EntityUtils;
import org.json.simple.JSONArray;
import org.json.simple.JSONObject;

import android.content.SharedPreferences;

import com.ideawise.picstorms.perferences.Preferences;
import com.ideawise.picstorms.shared.Server;

public class PhotoClient extends RestClient {

	public PhotoClient(String url) {
		super(url);
	}

	public  void like() {
		RestClient client = new RestClient(url);
		try {
			// the actual call here
			client.Execute(RequestMethod.POST, ResponseType.JSON_ARRAY);
//			client.AddParam("userId", );
		} catch (Exception e) {
			e.printStackTrace();
		}

		// retrieving the response of the call
//		Object response = client.getResponse();
//		JSONArray array = (JSONArray) response;
//		titles = new String[array.size()];
//		List<String> x = new ArrayList<String>();
//
//		for (int i = 0; i < array.size(); i++) {
//			JSONObject jsonObj = (JSONObject) array.get(i);
//			x.add((String) jsonObj.get("title"));
//		}
//		x.toArray(titles);
	}
}
