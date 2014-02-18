package com.ideawise.picstorms;

import android.graphics.Bitmap;
import android.widget.ImageView;

//Used to display bitmap in the UI thread
class BitmapDisplayer implements Runnable {
	final int stub_id = R.drawable.stub;
	Bitmap bitmap;
	ImageView imageView;

	public BitmapDisplayer(Bitmap b, ImageView i) {
		bitmap = b;
		imageView = i;
	}

	public void run() {
		if (bitmap != null)
			imageView.setImageBitmap(bitmap);
		else
			imageView.setImageResource(stub_id);
	}
}