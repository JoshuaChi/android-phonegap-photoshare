package com.ideawise.picstorms.beans;

public class Settings implements PicstormsType {

    private String mFeedsKey;
    private boolean mSendtotwitter;

    public Settings() {
    }

    public String getFeedsKey() {
        return mFeedsKey;
    }

    public void setFeedsKey(String feedsKey) {
        mFeedsKey = feedsKey;
    }

    public boolean sendtotwitter() {
        return mSendtotwitter;
    }

    public void setSendtotwitter(boolean sendtotwitter) {
        mSendtotwitter = sendtotwitter;
    }

}
