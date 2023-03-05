<?php

namespace App\Http\Livewire\Admin\Announcements;
use App\Models\Announcement as AnnouncementModel;
use App\Models\AnnouncementDetail as AnnouncementDetailModel;
use App\Models\Category as CategoryModel ;
use Livewire\Component;
use Livewire\WithPagination;


class AnnouncementDetailsWired extends Component
{
use WithPagination;
protected $paginationTheme = 'bootstrap';
public $announcement_key_moments;

    public $current_tab=0;
    public $current_announcement_name;
    public $current_announcement_id;
    // 'product_attributes.*.size' => 'required',

    protected  $rules=[
        'announcement_key_moments.*.image_description'=>'required'
    ];
    protected $messages = [
        'announcement_key_moments.*.image_description'=>'kindly provide a key moment description for this announcement'
    ];

    // current_tab will default to 0 as looping starts from 0
    public function tab_clicked ($tab_id){
        $this->current_tab=$tab_id;
        // dd($this->current_tab);
    }

    public function add_new_announcement(){

        $this->validate($this->rules,$this->messages);

    //     foreach ($this->product_attributes as $product_attribute) {
    //         $product_attribute->product_id = $this->product_id;

    //         $product_attribute->save();
    //     }
    //     $product = ProductsModel::find($this->product_id)->first()->toArray()['product_name'];
    //     $this->dispatchBrowserEvent('hide-produt-attr-modal', ["success_msg" => ' Product Attributes For ' . $product . ' Has Been Updated Successfully']);
    }


    public function get_key_moments($announcement_id){
        // dd($announcement_id);

        $this->announcement_key_moments = AnnouncementDetailModel::all()->where('announcement_id', $announcement_id);

        $this->current_announcement_id=$announcement_id;
        $this->current_announcement_name=AnnouncementModel::where(['id'=> $this->current_announcement_id])->first()->title;


        $this->dispatchBrowserEvent('show_announcement_key_moments');
    }
    public function add_announcement_keyMoment(){


        $this->announcement_key_moments->push(AnnouncementDetailModel::make());

    }

    public function render()
    {
        $categories = CategoryModel::where('status',1)->latest()->get();
        // dd($announcements);

        return view('livewire.admin.announcements.announcement-details-wired')->with(compact('categories'));
    }
}