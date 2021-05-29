import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { MonPremierComponent } from './mon-premier/mon-premier.component';

import { HttpClientModule } from '@angular/common/http';
import { TaskComponent } from './task/task.component';
import { TaskAddComponent } from './task-add/task-add.component';

import { FormsModule} from '@angular/forms';
import { NavbarComponent } from './navbar/navbar.component';
import { HomeComponent } from './home/home.component';
import { TaskEditComponent } from './task-edit/task-edit.component';
import { Ng2SearchPipeModule } from 'ng2-search-filter';

@NgModule({
  declarations: [
    AppComponent,
    MonPremierComponent,
    TaskComponent,
    TaskAddComponent,
    NavbarComponent,
    HomeComponent,
    TaskEditComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    HttpClientModule,
    FormsModule,
    Ng2SearchPipeModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
