package com.ideawise.picstorms;


import android.app.Activity;
import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;

public class LazyAdapter extends BaseAdapter {
    
    private Activity activity;
    private String[] data;
    private static LayoutInflater inflater=null;
    public ImageLoader imageLoader; 
    
    public LazyAdapter(Activity a, String[] d) {
        activity = a;
        data=d;
        inflater = (LayoutInflater)activity.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        imageLoader=new ImageLoader(activity.getApplicationContext());
    }

    public int getCount() {
        return data.length;
    }

    public String getItem(int position) {
        return data[position];
    }

    public long getItemId(int position) {
        return position;
    }
    
    public View getView(int position, View convertView, ViewGroup parent) {
        View vi=convertView;
        if(convertView==null)
            vi = inflater.inflate(R.layout.item, null);

//        TextView text=(TextView)vi.findViewById(R.id.text);;
//        System.out.println(R.id.image);
        ImageView image=(ImageView)vi.findViewById(R.id.image);
//        text.setText("item "+position);
        imageLoader.DisplayImage(data[position], activity, image);
        return vi;
    }
    
    public void setData(String[] d) {
    	this.data = d;
    }
}