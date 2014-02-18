package com.ideawise.picstorms.beans;

public class Theme implements PicstormsType {
	private String id;
	private String className;
	private String title;
	private String desc;
	private String created;
	private String currentPhotoNumers;

	public String getId() {
		return id;
	}

	public void setId(String id) {
		this.id = id;
	}

	public String getClassName() {
		return className;
	}

	public void setClassName(String className) {
		this.className = className;
	}

	public String getTitle() {
		return title;
	}

	public void setTitle(String title) {
		this.title = title;
	}

	public String getDesc() {
		return desc;
	}

	public void setDesc(String desc) {
		this.desc = desc;
	}

	public String getCreated() {
		return created;
	}

	public void setCreated(String created) {
		this.created = created;
	}

	public String getCurrentPhotoNumers() {
		return currentPhotoNumers;
	}

	public void setCurrentPhotoNumers(String currentPhotoNumers) {
		this.currentPhotoNumers = currentPhotoNumers;
	}

}
