import { Component, OnInit } from '@angular/core';
import { WebsitedataService } from '../websitedata.service';

@Component({
  selector: 'app-website',
  templateUrl: './website.component.html',
  styleUrls: ['./website.component.css']
})
export class WebsiteComponent implements OnInit {
  websiteD:any;
  constructor( private websitedata: WebsitedataService ) { }

  ngOnInit(): void {
    var URL = "https://www.google.com/";
    var depth = 1;
    // get parameters from form
    var url = window.location.href;
    var captured = /url=([^&]+)/.exec(url);
    
    if (captured){
      URL = (captured[1]);
    }
    var captured = /depth=([^&]+)/.exec(url);
    if (captured){
      depth = (Number)(captured[1]);
      console.log(depth);
    }
    this.websitedata.setWebsiteData(URL,depth);
    this.websitedata.getWebsiteData().subscribe(res => {
      console.log(res);
      this.websiteD =  res;
    });
  }
  
}
