import { Injectable } from '@angular/core';

import { catchError } from 'rxjs/internal/operators';
import { HttpClient, HttpHeaders, HttpErrorResponse } from '@angular/common/http';
import { Observable, throwError } from 'rxjs';
import { map } from 'rxjs/operators';

const endpoint = "https://jsonplaceholder.typicode.com/posts/1/comments"
const endpoint2 = "http://localhost:8000/api/"

export interface Task {
  id: number;
  title: string;
  status: string;
  priority: string;
  task_date: Date;
  createdAt:Date;
  category:string;
}

export interface Post {
  postId: string;
  id: number;
  name: string;
  email: string;
  body: string;
}

@Injectable({
  providedIn: 'root'
})
export class RestService {

  task : Task[]= []

  constructor(private http: HttpClient) {}

    getTasks(): Observable<any>{
      return this.http.get<Task>(endpoint2 + 'tasks');
    }
    addTask(createTask:any): Observable<any>{
      return this.http.post(endpoint2+'create/task', createTask);
    }
    getTask(id:Number): Observable<any>{
      return this.http.get<Task>(endpoint2 + 'task/'+id);
    }
    updtateTask(id:Number,task:any): Observable<any>{
      return this.http.put<any>(endpoint2 + 'edit/'+id,task);
    }
    deleteTask(id:Number): Observable<any>{
      return this.http.delete<any>(endpoint2 + 'delete/'+id);
    }
}
