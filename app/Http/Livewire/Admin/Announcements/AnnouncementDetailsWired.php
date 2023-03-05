<?php

namespace App\Http\Livewire\Admin\Announcements;

use App\Models\Announcement as AnnouncementModel;
use App\Models\AnnouncementDetail as AnnouncementDetailModel;
use App\Models\Category as CategoryModel;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class AnnouncementDetailsWired extends Component
{
    use WithFileUploads;

    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $announcement_key_moments;

    public $current_tab = 0;
    public $current_announcement_name;
    public $current_announcement_id;

    protected $rules = [
        'announcement_key_moments.*.image_description' => "required|string",
        'announcement_key_moments.*.image_sub_title' => "nullable|string",
        // 'announcement_key_moments.*.tmp_image' => "nullable|image",
    ];
    protected $messages = [
        'announcement_key_moments.*.image_description' => 'kindly provide a key moment description for this announcement',
        'announcement_key_moments.*.image_sub_title' => 'kindly provide a valid key moment statement/leave blank for this announcement',
      //  'announcement_key_moments.*.tmp_image' => 'kindly provide a key moment [IMAGE] /leave blank for this announcement',


    ];

    // current_tab will default to 0 as looping starts from 0
    public function tab_clicked($tab_id)
    {
        $this->current_tab = $tab_id;
        // dd($this->current_tab);
    }
    public function get_key_moments($announcement_id)
    {
        // dd($announcement_id);

        $this->announcement_key_moments = AnnouncementDetailModel::all()->where('announcement_id', $announcement_id);

        $this->current_announcement_id = $announcement_id;
        $this->current_announcement_name = AnnouncementModel::where(['id' => $this->current_announcement_id])->first()->title;

        $this->dispatchBrowserEvent('show_announcement_key_moments');
    }
    public function add_announcement_keyMoment()
    {
        $announcement_instance=AnnouncementDetailModel::make();
        $announcement_instance->tmp_image="DZGFJH";



        $this->announcement_key_moments->push($announcement_instance);

    }

    public function add_new_announcement()
    {



        $this->validate($this->rules, $this->messages);
        dd($this->announcement_key_moments);

        // foreach ($this->announcement_key_moments as $key_moment) {
        //     // dd( $key_moment);
        //     $key_moment->announcement_id = $this->current_announcement_id;

        //    $key_moment->save();
        // }
        //     $product = ProductsModel::find($this->product_id)->first()->toArray()['product_name'];
        //     $this->dispatchBrowserEvent('hide-produt-attr-modal', ["success_msg" => ' Product Attributes For ' . $product . ' Has Been Updated Successfully']);
    }



    public function render()
    {
        $categories = CategoryModel::where('status', 1)->latest()->get();
        // dd($announcements);

        return view('livewire.admin.announcements.announcement-details-wired')->with(compact('categories'));
    }
}