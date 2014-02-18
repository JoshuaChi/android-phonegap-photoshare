package com.ideawise.picstorms.shared;

import java.util.ArrayList;
import java.util.Arrays;
import java.util.List;

import org.json.simple.JSONArray;
import org.json.simple.JSONObject;

import com.ideawise.picstorms.RequestMethod;
import com.ideawise.picstorms.ResponseType;
import com.ideawise.picstorms.RestClient;

public class PhotoSource {

	private static String[] titles = null;
	
	
	private  static void initUrls(){
		RestClient client = new RestClient(Server.getOverviewUrl());
		try {
			// the actual call here
			client.Execute(RequestMethod.POST, ResponseType.JSON_ARRAY);
		} catch (Exception e) {
			e.printStackTrace();
		}

		// retrieving the response of the call
		Object response = client.getResponse();
		JSONArray array = (JSONArray) response;
		titles = new String[array.size()];
		List<String> x = new ArrayList<String>();

		for (int i = 0; i < array.size(); i++) {
			JSONObject jsonObj = (JSONObject) array.get(i);
			x.add((String) jsonObj.get("title"));
		}
		x.toArray(titles);
	}
	
	
	public static String[] getTitles(boolean falseRefresh)
	{
		if(falseRefresh == true || titles == null){
			initUrls();
		}
		return titles;
	}
	
	
	/**
	 * photo overview page request urls
	 * 
	 * @return
	 */
	public static String[] getThumbnailUrls(boolean falseRefresh) {
		if(falseRefresh == true || titles == null){
			initUrls();
		}
		String[] thumbs = new String[titles.length];
		for(int i=0; i < titles.length; i++){
			thumbs[i] = Server.getBaseImageDomain() + titles[i];
		}
		return thumbs;
		
	}
	
	public static String[] getBigSizeUrls(boolean falseRefresh) {
		if(falseRefresh == true || titles == null){
			initUrls();
		}

		System.out.println("title>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>");
		System.out.println(Arrays.toString(titles));
		String[] bigSizeUrls = new String[titles.length];
		
		for(int i=0; i < titles.length; i++){
			bigSizeUrls[i] = Server.getBaseBigImageDomain() + titles[i];
		}
		
		return bigSizeUrls;
		

	}
}
