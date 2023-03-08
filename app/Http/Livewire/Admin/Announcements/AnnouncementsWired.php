<?php

namespace App\Http\Livewire\Admin\Announcements;

use App\Models\Announcement as AnnouncementModel;
use App\Models\Category as CategoryModel;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class AnnouncementsWired extends Component
{
    public $addNewAnnouncement;
    public $inputs = [];

    public $announcement_id;
    public $btn_text;
    protected $listeners = ['confirm_delete_announcement_alert'];

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'title' => 'required|min:30',
        'category_id'=> 'required|numeric',
        'status' => 'required',

    ];

    public function new_announcement()
    {
        // dd('hmm');
        // $this->dispatchBrowserEvent('clear-file-fields');
        // the event above clears the input fields

        $this->addNewAnnouncement = true;
        $this->inputs = [];
        $this->dispatchBrowserEvent('show_add_announcement_modal');
        // triggering the show-add-product-modal to show  modal
        $this->btn_text = $this->addNewAnnouncement == true ? 'Save' : 'Save Changes';

    }

    public function edit_announcement($announcement_id)
    {
        $this->announcement_id = $announcement_id;

        $this->addNewAnnouncement = false;
        $this->inputs = AnnouncementModel::where(['id' => $announcement_id])->first()->toArray();
        $this->dispatchBrowserEvent('show_add_announcement_modal');
        $this->btn_text = $this->addNewAnnouncement == true ? 'Save' : 'Save Changes';

    }
    public function delete_announcement($announcement_id)
    {
        $this->announcement_id = $announcement_id;
        $this->dispatchBrowserEvent('show_delete_announcement_alert');

    }
    public function update_announcement()
    {
        $validated_data = Validator::make($this->inputs, $this->rules)->validate();
        AnnouncementModel::where(['id' => $this->announcement_id])->update($validated_data);
        $this->dispatchBrowserEvent('hide_add_announcement_modal');
        $this->dispatchBrowserEvent('show-success-toast', ["success_msg" => ' announcement Updated Successfully']);

    }
    public function confirm_delete_announcement_alert()
    {
        AnnouncementModel::findOrFail($this->announcement_id)->delete();
        $this->dispatchBrowserEvent('show-success-toast', ["success_msg" => ' announcement Deleted Successfully']);

    }

    private function array_to_object($array)
    {
        return (object) $array;

    }

    public function submit_add_new_announcement()
    {
        //status validation not working
        $validated_data = Validator::make($this->inputs, $this->rules)->validate();
        $announcement = new AnnouncementModel();
        $validated_data = $this->array_to_object($validated_data);

        $announcement->title = $validated_data->title;
        $announcement->category_id = $validated_data->category_id;
        $announcement->status = $this->array_to_object($this->inputs)->status;
        $announcement->save();
        $this->addNewAnnouncement = false;

        redirect()->back();
        $this->dispatchBrowserEvent('hide_add_announcement_modal');
        $this->dispatchBrowserEvent('show-success-toast', ["success_msg" => 'New announcement Added Successfully']);

    }

    public function change_announcement_status($announcement_id, $announcement_status)
    {
        AnnouncementModel::where(['id' => $announcement_id])->update(['status' => $announcement_status == "1" ? 0 : 1]);
        $this->dispatchBrowserEvent('show-success-toast', ["success_msg" => 'Announcement  Status Updated Successfully']);

    }

    public function render()
    {
        $announcements = AnnouncementModel::with(['get_announcement_category'])->latest()->paginate(50);
        $categories = CategoryModel::latest()->get();

        return view('livewire.admin.announcements.announcements-wired')->with(compact('announcements','categories'));
    }
}