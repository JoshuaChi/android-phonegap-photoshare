package com.ideawise.picstorms.shared;

import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;

import android.app.Application;

public class Server extends Application {
	public static final boolean DEBUG = false;
	public static final boolean PARSER_DEBUG = false;
	public static final String PREFS_NAME = "STORM_PERFERENCE";

	public static final boolean IS_PROD = true;

	public static final String HASH_PREFIX = "p1cst0rms.c0mI0vu98becs$%";

	// LAB URLs
	public static final String LAB_SIGNUP_URL = "http://localhost/frontend_dev.php/user/register";
	private static final String LAB_BASE_IMAGE_DOMAIN = "http://localhost/uploads/thumbnail/";
	private static final String LAB_BASE_BIG_IMAGE_DOMAIN = "http://localhost/uploads/photos/";
	private static final String LAB_UPLOAD_URL = "http://localhost/frontend_dev.php/photo/upload";
	private static final String LAB_OVERVIEW_URL = "http://localhost/frontend_dev.php/photo/browse";
	private static final String LAB_LOGIN_URL = "http://localhost/frontend_dev.php/user/login";
	private static final String LAB_CURRENT_THEME_URL = "http://localhost/frontend_dev.php/theme/index";
	private static final String LAB_LIKE_URL = "http://localhost/photo/like";
	private static final String LAB_VIEW_URL = "http://localhost/photo/view";

	// PROD URLs
	public static final String PROD_SIGNUP_URL = "http://www.example.com/user/register";
	private static final String PROD_BASE_IMAGE_DOMAIN = "http://www.example.com/uploads/thumbnail/";
	private static final String PROD_BASE_BIG_IMAGE_DOMAIN = "http://www.example.com/uploads/photos/";
	private static final String PROD_UPLOAD_URL = "http://www.example.com/photo/upload";
	private static final String PROD_OVERVIEW_URL = "http://www.example.com/photo/browse";
	private static final String PROD_LOGIN_URL = "http://www.example.com/user/login";
	private static final String PROD_CURRENT_THEME_URL = "http://www.example.com/theme/index";
	private static final String PROD_LIKE_URL = "http://www.example.com/photo/like";
	private static final String PROD_VIEW_URL = "http://www.example.com/photo/view";

	public void setCredentials(String userName, String password) {
	}

	public static String getBaseImageDomain() {
		if (IS_PROD) {
			return PROD_BASE_IMAGE_DOMAIN;
		} else {
			return LAB_BASE_IMAGE_DOMAIN;
		}
	}

	public static String getBaseBigImageDomain() {
		if (IS_PROD) {
			return PROD_BASE_BIG_IMAGE_DOMAIN;
		} else {
			return LAB_BASE_BIG_IMAGE_DOMAIN;
		}
	}

	public static String getUploadUrl() {
		if (IS_PROD) {
			return PROD_UPLOAD_URL;
		} else {
			return LAB_UPLOAD_URL;
		}
	}

	public static String getPhotoViewUrl() {
		if (IS_PROD) {
			return PROD_VIEW_URL;
		} else {
			return LAB_VIEW_URL;
		}
	}

	public static String getLikeUrl() {
		if (IS_PROD) {
			return PROD_LIKE_URL;
		} else {
			return LAB_LIKE_URL;
		}
	}

	public static String getOverviewUrl() {
		if (IS_PROD) {
			return PROD_OVERVIEW_URL;
		} else {
			return LAB_OVERVIEW_URL;
		}
	}

	public static String getLoginUrl() {
		if (IS_PROD) {
			return PROD_LOGIN_URL;
		} else {
			return LAB_LOGIN_URL;
		}
	}

	public static String getSingupUrl() {
		if (IS_PROD) {
			return PROD_SIGNUP_URL;
		} else {
			return LAB_SIGNUP_URL;
		}
	}

	public static String getRequestCurrentThemeUrl() {
		if (IS_PROD) {
			return PROD_CURRENT_THEME_URL;
		} else {
			return LAB_CURRENT_THEME_URL;
		}
	}

	public static String md5(String input) {
		String res = "";
		try {
			MessageDigest algorithm = MessageDigest.getInstance("MD5");
			algorithm.reset();
			algorithm.update(input.getBytes());
			byte[] md5 = algorithm.digest();
			String tmp = "";
			for (int i = 0; i < md5.length; i++) {
				tmp = (Integer.toHexString(0xFF & md5[i]));
				if (tmp.length() == 1) {
					res += "0" + tmp;
				} else {
					res += tmp;
				}
			}
		} catch (NoSuchAlgorithmException ex) {
		}
		return res;
	}

}
