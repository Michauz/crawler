import { TestBed } from '@angular/core/testing';

import { WebsitedataService } from './websitedata.service';

describe('WebsitedataService', () => {
  let service: WebsitedataService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(WebsitedataService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
