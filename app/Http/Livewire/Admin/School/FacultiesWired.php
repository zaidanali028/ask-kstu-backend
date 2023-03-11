<?php

namespace App\Http\Livewire\Admin\School;

use Livewire\Component;

use App\Models\Faculty as FacultyModel;
use App\Models\Department as DepartmentModel;
use App\Models\Program as ProgramModel;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Validator;

class FacultiesWired extends Component
{
    use WithPagination;
    // public $categories;
    public $addNewfaculty;
    public $inputs = [];
    public $faculty_id;
    public $btn_text;
    protected $listeners = ['confirm_delete_faculty_alert',];
    protected $paginationTheme = 'bootstrap';
    public $moment_img_path = 'moment_imgs';
    public $announcement_images = "announcement_imgs";




    protected $rules = [
        'name' => 'required',
        'status' => 'required',

    ];
      private function array_to_object($array){
        return (object) $array;

    }
     public function delete_program($program_id)
    {
        ProgramModel::findOrfail($program_id)->delete();

    }
    public function delete_department($dept_id)
    {
        // delete the programs under this department before deleting this department
        $department = DepartmentModel::where(['id' => $dept_id])->first();
        $department_programs = $department['get_department_programs'];
        foreach ($department_programs as $department_program) {
            $this->delete_program($department_program->id);

        }
        $department->delete();
        $this->dispatchBrowserEvent('show-success-toast', ["success_msg" => ' Department Removed Successfully']);

        // dd($department_programs);

    }
    public function confirm_delete_faculty_alert()
    {
        // delete the departments under this faculty before deleting this faculty

        $faculty = FacultyModel::where(['id' => $this->faculty_id])->first();
        $faculty_departments =$faculty['get_faculty_departments'];
        foreach($faculty_departments as $faculty_department){
            $this->delete_department($faculty_department->id);


        }
        $faculty->delete();
        $this->dispatchBrowserEvent('show-success-toast', ["success_msg" => ' Faculty Removed Successfully']);




    }

    public function submit_add_new_faculty()
    {
        //status validation not working
        $validated_data = Validator::make($this->inputs, $this->rules)->validate();
        $faculty=new FacultyModel();
        $validated_data=$this->array_to_object($validated_data);

        $faculty->name=$validated_data->name;
        $faculty->status=$this->array_to_object($this->inputs)->status;
        $faculty->save();
        $this->addNewfaculty = false;



        redirect()->back();
        $this->dispatchBrowserEvent('hide_add_faculty_modal');
        $this->dispatchBrowserEvent('show-success-toast',["success_msg"=>'New faculty Added Successfully']);





    }

    public function change_faculty_status($faculty_id,$faculty_status){
        FacultyModel::where(['id'=> $faculty_id])->update(['status'=>$faculty_status=="1"?0:1]);
        $this->dispatchBrowserEvent('show-success-toast',["success_msg"=>'faculty Status Updated Successfully']);


    }
    public function hide_modal()
    {
        $this->dispatchBrowserEvent('hide_add_faculty_modal');

    }


    public function new_faculty()
    {
        // dd('hmm');
        // $this->dispatchBrowserEvent('clear-file-fields');
        // the event above clears the input fields

        $this->addNewfaculty = true;
        $this->inputs = [];
        $this->dispatchBrowserEvent('show_add_faculty_modal');
        // triggering the show-add-product-modal to show  modal
        $this->btn_text = $this->addNewfaculty == true ? 'Save' : 'Save Changes';

    }

    public function edit_faculty($faculty_id){
        $this->faculty_id=$faculty_id;

        $this->addNewfaculty = false;
        $this->inputs = FacultyModel::where(['id'=> $faculty_id])->first()->toArray();
        $this->dispatchBrowserEvent('show_add_faculty_modal');
        $this->btn_text = $this->addNewfaculty == true ? 'Save' : 'Save Changes';


    }
    public function delete_faculty($faculty_id){
        $this->faculty_id=$faculty_id;
        $this->dispatchBrowserEvent('show_delete_faculty_alert');



    }
    public function update_faculty(){
        $validated_data = Validator::make($this->inputs, $this->rules)->validate();
        FacultyModel::where(['id'=> $this->faculty_id])->update($validated_data);
        $this->dispatchBrowserEvent('hide_add_faculty_modal');
        $this->dispatchBrowserEvent('show-success-toast',["success_msg"=>' faculty Updated Successfully']);



    }
    public function render()
    {
        $faculties = FacultyModel::latest()->paginate(50);


        return view('livewire.admin.school.faculties-wired')
        ->with(compact('faculties'));

    }
}