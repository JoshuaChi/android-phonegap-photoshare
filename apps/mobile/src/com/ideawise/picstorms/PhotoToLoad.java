package com.ideawise.picstorms;

import android.widget.ImageView;

//Task for the queue
public class PhotoToLoad
{
    public String url;
    public ImageView imageView;
    public PhotoToLoad(String u, ImageView i){
        url=u; 
        imageView=i;
    }
}