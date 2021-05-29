import { Component, Input, OnInit } from '@angular/core';
import {RestService} from '../rest.service';
import { ActivatedRoute, Router } from '@angular/router';
import { NgForm } from '@angular/forms';

@Component({
  selector: 'app-task-add',
  templateUrl: './task-add.component.html',
  styleUrls: ['./task-add.component.scss']
})
export class TaskAddComponent implements OnInit {

  task = {
    title: '',
    status: null,
    priority: 'normal',
    task_date: '',
    category: 'Autre'
  }


  id:any=null;  
  header!:string;


  
  constructor(public rest:RestService, private route: ActivatedRoute, private router:Router) { 
    
  }
  
  ngOnInit(): void {
    
    this.id = this.route.snapshot.paramMap.get('id');
    this.header = this.id === '0' ? 'Ajouter une tâche': 'Editer la tâche';

    if (this.id !=0){
      this.rest.getTask(this.id).subscribe(
        (resp)=>{
          this.task = resp;
        }
      )
    }


    

  }
  
  addTask(regForm:NgForm){

    if(regForm.valid){
        if(this.id === '0'){
          if(confirm("Vous êtes sûr de créer la tâche?")){
            this.rest.addTask(this.task).subscribe(
              (result)=> {this.router.navigate(['/tasks']);}
            )
          }
          
        }
        else{
          if(confirm("Vous êtes sûr de modifier la tâche?")){
            this.rest.updtateTask(this.id,this.task).subscribe(
              (result)=> {this.router.navigate(['/tasks']);}
            )
          }     
        }
    }
    
    
  }
}
