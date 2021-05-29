import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { TaskComponent} from './task/task.component';
import { TaskAddComponent} from './task-add/task-add.component';
import { HomeComponent} from './home/home.component';
import { TaskEditComponent } from './task-edit/task-edit.component';



const routes: Routes = [
  {
    path: 'tasks',
    component: TaskComponent
  },
  {
    path: 'task/add/:id',
    component: TaskAddComponent
  },
  {
    path: 'task/edit/:id',
    component: TaskAddComponent
  },
  {
    path: 'home',
    component: HomeComponent
  },
  {
    path: '',
    redirectTo: '/home',
    pathMatch: 'full'
  }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
