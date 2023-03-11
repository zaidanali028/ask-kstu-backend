<?php

namespace App\Http\Livewire\Admin\School;

use App\Models\Department as DepartmentModel;
use App\Models\Faculty as FacultyModel;
use App\Models\Program as ProgramModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class DepartmentsWired extends Component
{
    use WithPagination;

    public $addNewDepartment;
    public $inputs = [];
    public $department_id;
    public $btn_text;
    protected $rules = [
        'name' => 'required|unique:departments',
        'status' => 'required',
        'faculty_id' => 'required',

    ];
    protected $listeners = ['confirm_delete_department_alert'];

    private function array_to_object($array)
    {
        return (object) $array;

    }
    public function delete_program($program_id)
    {
        ProgramModel::findOrfail($program_id)->delete();

    }
    public function confirm_delete_department_alert()
    {
        // delete the programs under this department before deleting this department
        $department = DepartmentModel::where(['id' => $this->department_id])->first();
        $department_programs = $department['get_department_programs'];
        foreach ($department_programs as $department_program) {
            $this->delete_program($department_program->id);

        }
        $department->delete();
        $this->dispatchBrowserEvent('show-success-toast', ["success_msg" => ' Department Removed Successfully']);

        // dd($department_programs);

    }

    public function submit_add_new_department()
    {
        //status validation not working
        $validated_data = Validator::make($this->inputs, $this->rules)->validate();
        $department = new DepartmentModel();
        $validated_data = $this->array_to_object($validated_data);

        $department->name = $validated_data->name;
        $department->status = $this->array_to_object($this->inputs)->status;
        $department->faculty_id = $this->array_to_object($this->inputs)->faculty_id;
        $department->save();
        $this->addNewDepartment = false;

        redirect()->back();
        $this->dispatchBrowserEvent('hide_add_department_modal');
        $this->dispatchBrowserEvent('show-success-toast', ["success_msg" => 'New Department Added Successfully']);

    }

    public function change_department_status($department_id, $department_status)
    {
        DepartmentModel::where(['id' => $department_id])->update(['status' => $department_status == "1" ? 0 : 1]);
        $this->dispatchBrowserEvent('show-success-toast', ["success_msg" => 'department Status Updated Successfully']);

    }
    public function hide_modal()
    {
        $this->dispatchBrowserEvent('hide_add_department_modal');

    }

    public function new_department()
    {
        // dd('hmm');
        // $this->dispatchBrowserEvent('clear-file-fields');
        // the event above clears the input fields

        $this->addNewDepartment = true;
        $this->inputs = [];
        $this->dispatchBrowserEvent('show_add_department_modal');
        // triggering the show-add-product-modal to show  modal
        $this->btn_text = $this->addNewDepartment == true ? 'Save' : 'Save Changes';

    }

    public function edit_department($department_id)
    {
        $this->department_id = $department_id;

        $this->addNewDepartment = false;
        $this->inputs = DepartmentModel::where(['id' => $department_id])->first()->toArray();
        $this->dispatchBrowserEvent('show_add_department_modal');
        $this->btn_text = $this->addNewDepartment == true ? 'Save' : 'Save Changes';

    }
    public function delete_department($department_id)
    {
        $this->department_id = $department_id;
        $this->dispatchBrowserEvent('show_delete_department_alert');

    }
    public function update_department()
    {
        $this->rules['name'] = 'required|' . Rule::unique('departments', 'name')
            ->ignore($this->department_id);
        // ignoring unique constraint when updating a department
        $validated_data = Validator::make($this->inputs, $this->rules)->validate();
        DepartmentModel::where(['id' => $this->department_id])->update($validated_data);
        $this->dispatchBrowserEvent('hide_add_department_modal');
        $this->dispatchBrowserEvent('show-success-toast', ["success_msg" => ' department Updated Successfully']);

    }
    public function render()
    {
        $faculties = FacultyModel::where(['status' => 1])->latest()->get();
        $departments = DepartmentModel::latest()->with(['get_department_faculty'])->paginate(50);

        return view('livewire.admin.school.departments-wired', ['departments' => $departments, 'faculties' => $faculties]);
    }
}