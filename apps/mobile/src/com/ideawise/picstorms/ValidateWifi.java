package com.ideawise.picstorms;

import android.app.Activity;
import android.content.Context;
import android.content.ContextWrapper;
import android.net.wifi.WifiInfo;
import android.net.wifi.WifiManager;

public class ValidateWifi {
	ContextWrapper appContext;
	private static final int NO_CONNECTION_ID = -1;
	
	public ValidateWifi(Activity a)
	{
		appContext = (ContextWrapper)a.getApplicationContext();
	}
	
	public boolean canUseWifi()
	{
		boolean retval = false;
		
		WifiManager wifiMgr = (WifiManager)appContext.getSystemService(Context.WIFI_SERVICE);
		if( wifiMgr.isWifiEnabled())
		{
			WifiInfo information = wifiMgr.getConnectionInfo();
			retval = information.getNetworkId() != NO_CONNECTION_ID;
		}
		
		return retval;
	}

}
