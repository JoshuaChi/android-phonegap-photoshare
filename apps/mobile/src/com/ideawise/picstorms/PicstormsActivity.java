package com.ideawise.picstorms;

import android.os.Bundle;

import com.phonegap.DroidGap;


public class PicstormsActivity extends DroidGap {
  
  static final int DIALOG_ABOUT = 1;
  
  /** Called when the activity is first created. */
  @Override
  public void onCreate(Bundle savedInstanceState) {
    super.onCreate(savedInstanceState);
    super.loadUrl("file:///android_asset/www/index.html");
  }
  
}