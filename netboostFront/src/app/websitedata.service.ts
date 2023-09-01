import { Injectable } from '@angular/core';
import { environment } from 'src/environments/environment';
import { HttpClient } from '@angular/common/http'

@Injectable({
  providedIn: 'root'
})
export class WebsitedataService {

  websiteData:any;
  private URL  = environment.API_URL;
  
  constructor(private httpRequest:HttpClient) { }
  getWebsiteData(){
    return this.websiteData;
  }
  setWebsiteData(url,depth){
    this.websiteData = this.httpRequest.get(this.URL + "website?url=" + url + "&depth=" + depth);
  }
}
