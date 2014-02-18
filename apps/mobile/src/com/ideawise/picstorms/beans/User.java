package com.ideawise.picstorms.beans;

public class User implements PicstormsType {

	private String mName;
	private String mEmail;
	private String mCreated;
	private String mId;
	private Settings mSettings;
	private String mLoginCount;

	public User() {
	}

	public String getName() {
		return mName;
	}

	public void setName(String Name) {
		mName = Name;
	}

	public String getCreated() {
		return mCreated;
	}

	public void setCreated(String created) {
		mCreated = created;
	}

	public String getEmail() {
		return mEmail;
	}

	public void setEmail(String email) {
		mEmail = email;
	}

	public String getLoginCount() {
		return mLoginCount;
	}

	public void setLoginCount(String loginCount) {
		mLoginCount = loginCount;
	}

	public String getId() {
		return mId;
	}

	public void setId(String id) {
		mId = id;
	}

	public Settings getSettings() {
		return mSettings;
	}

	public void setSettings(Settings settings) {
		mSettings = settings;
	}

}