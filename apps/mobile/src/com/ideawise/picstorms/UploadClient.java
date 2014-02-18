package com.ideawise.picstorms;

import java.io.File;
import java.io.IOException;
import java.io.UnsupportedEncodingException;
import java.nio.charset.Charset;
import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.HttpVersion;
import org.apache.http.NameValuePair;
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

import android.content.SharedPreferences;

import com.ideawise.picstorms.perferences.Preferences;
import com.ideawise.picstorms.shared.Server;

public class UploadClient extends RestClient {

	File file;
	String mimetype;

	public UploadClient(String url, File file, String mimetype) {
		super(url);
		this.file = file;
		this.mimetype = mimetype;
	}

	public void upload(SharedPreferences settings){
		HttpClient httpclient = new DefaultHttpClient();
	    httpclient.getParams().setParameter(CoreProtocolPNames.PROTOCOL_VERSION, HttpVersion.HTTP_1_1);

	    HttpPost httppost = new HttpPost(url);        
        
	    //add file parameter
	    MultipartEntity mpEntity = new MultipartEntity();
	    ContentBody cbFile = new FileBody(file, mimetype);
	    mpEntity.addPart("file", cbFile);
	    
	    //add extra parameters
	    try {
	    	String userName = Preferences.get(settings, Preferences.PREFERENCE_LOGIN);
			mpEntity.addPart("userName", new StringBody(userName));
		    mpEntity.addPart("themeId", new StringBody(Preferences.get(settings, Preferences.CURRENT_THEME_ID)));
		    mpEntity.addPart("photoDesc", new StringBody(""));
		    mpEntity.addPart("photoLocation", new StringBody(""));
			mpEntity.addPart("md5", new StringBody(Server.md5(Server.HASH_PREFIX + userName)));

		} catch (UnsupportedEncodingException e1) {
			e1.printStackTrace();
		}
	    
	    
	    httppost.setEntity(mpEntity);
	    

	    System.out.println("executing request " + httppost.getRequestLine());
	    HttpResponse response;
		try {
			response = httpclient.execute(httppost);
		    HttpEntity resEntity = response.getEntity();

		    System.out.println("............getStatusLine:"+response.getStatusLine());
		    if (resEntity != null) {
		      System.out.println("............resEntity:"+EntityUtils.toString(resEntity));
		    }
		    if (resEntity != null) {
		      resEntity.consumeContent();
		    }

		    httpclient.getConnectionManager().shutdown();
		} catch (ClientProtocolException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		} catch (IOException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	
	public void Execute(RequestMethod method) {
		switch (method) {
		case POST: {
			try {
				HttpPost request = new HttpPost(url);

				MultipartEntity entity = new MultipartEntity();
				ContentBody cbFile = new FileBody(file, mimetype);
				entity.addPart("upload", cbFile);

				// add headers
				for (NameValuePair h : headers) {
					request.addHeader(h.getName(), h.getValue());
				}

				// I resort to StringBody in multipart entity for the params
				for (NameValuePair p : params) {
					entity.addPart(p.getName(), new StringBody(p.getValue()));
				}
				request.setEntity(entity);

				executeRequest(request, url, ResponseType.JSON_ARRAY);
			} catch (Exception e) {
				e.printStackTrace();
			}

			break;
		}
		}
	}
}