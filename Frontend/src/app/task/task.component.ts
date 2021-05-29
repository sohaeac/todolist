import { Component, OnInit } from '@angular/core';
import { Post, RestService, Task } from '../rest.service';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-task',
  templateUrl: './task.component.html',
  styleUrls: ['./task.component.scss']
})
export class TaskComponent implements OnInit {

  tasks: Task[] = [];

  test:boolean=true;

  searchText:any
  

  constructor(public rest:RestService, private route: ActivatedRoute, private router:Router) { }

  ngOnInit(): void {

    this.getTasks()
  }

  getTasks(){
    this.rest.getTasks().subscribe(
      (resp)=>{
        console.log(resp)
        this.tasks = resp;
      }
    )
  }

  add(){
    this.router.navigate(["/task-add"]);
  }

  delete(id:number){
    if(confirm("Vous êtes sûr de supprimer la tâche?")){
      this.rest.deleteTask(id).subscribe(()=>{
      this.ngOnInit()
      })
    }
    
  }

  

  


  
}
