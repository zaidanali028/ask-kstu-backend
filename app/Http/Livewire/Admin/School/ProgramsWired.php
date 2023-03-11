<?php

namespace App\Http\Livewire\Admin\School;
use App\Models\Department as DepartmentModel;
use App\Models\Program as ProgramModel;
use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Livewire\WithPagination;

class ProgramsWired extends Component
{
use WithPagination;

    public $addNewProgram;
    public $inputs = [];
    public $program_id;
    public $btn_text;
    protected $rules = [
        'name' => 'required|unique:programs',
        'status' => 'required',
        'dept_id' => 'required',

    ];
    protected $listeners = ['confirm_delete_program_alert'];

    private function array_to_object($array)
    {
        return (object) $array;

    }
    public function confirm_delete_program_alert()
    {
      ProgramModel::findOrfail($this->program_id)->delete();
      $this->dispatchBrowserEvent('show-success-toast', ["success_msg" => ' Program Removed Successfully']);



    }

    public function submit_add_new_program()
    {
        //status validation not working
        $validated_data = Validator::make($this->inputs, $this->rules)->validate();
        $program = new ProgramModel();
        $validated_data = $this->array_to_object($validated_data);

        $program->name = $validated_data->name;
        $program->status = $this->array_to_object($this->inputs)->status;
        $program->dept_id = $this->array_to_object($this->inputs)->dept_id;
        $program->save();
        $this->addNewProgram = false;

        redirect()->back();
        $this->dispatchBrowserEvent('hide_add_program_modal');
        $this->dispatchBrowserEvent('show-success-toast', ["success_msg" => 'New program Added Successfully']);

    }

    public function change_program_status($program_id, $program_status)
    {
        ProgramModel::where(['id' => $program_id])->update(['status' => $program_status == "1" ? 0 : 1]);
        $this->dispatchBrowserEvent('show-success-toast', ["success_msg" => 'program Status Updated Successfully']);

    }
    public function hide_modal()
    {
        $this->dispatchBrowserEvent('hide_add_program_modal');

    }

    public function new_program()
    {
        // dd('hmm');
        // $this->dispatchBrowserEvent('clear-file-fields');
        // the event above clears the input fields

        $this->addNewProgram = true;
        $this->inputs = [];
        $this->dispatchBrowserEvent('show_add_program_modal');
        // triggering the show-add-product-modal to show  modal
        $this->btn_text = $this->addNewProgram == true ? 'Save' : 'Save Changes';

    }

    public function edit_program($program_id)
    {
        $this->program_id = $program_id;

        $this->addNewProgram = false;
        $this->inputs = ProgramModel::where(['id' => $program_id])->first()->toArray();
        $this->dispatchBrowserEvent('show_add_program_modal');
        $this->btn_text = $this->addNewProgram == true ? 'Save' : 'Save Changes';

    }
    public function delete_program($program_id)
    {
        $this->program_id = $program_id;
        $this->dispatchBrowserEvent('show_delete_program_alert');

    }
    public function update_program()
    {
        $this->rules['name'] = 'required|' . Rule::unique('programs', 'name')
            ->ignore($this->program_id);
            // ignoring unique constraint when updating a program
        $validated_data = Validator::make($this->inputs, $this->rules)->validate();
        ProgramModel::where(['id' => $this->program_id])->update($validated_data);
        $this->dispatchBrowserEvent('hide_add_program_modal');
        $this->dispatchBrowserEvent('show-success-toast', ["success_msg" => ' program Updated Successfully']);

    }

    public function render()
    {
        $programs = ProgramModel::with(['get_program_department'])->latest()->paginate(50);
        // dd( $programs );

        $depts= DepartmentModel::latest()->get();
        // dd($depts);
        return view('livewire.admin.school.programs-wired', ['departments' => $depts, 'programs' => $programs]);
    }
}