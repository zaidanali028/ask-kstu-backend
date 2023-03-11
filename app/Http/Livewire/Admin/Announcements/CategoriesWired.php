<?php

namespace App\Http\Livewire\Admin\Announcements;


use App\Models\Category as CategoryModel;
use App\Models\Announcement as AnnouncementModel;
use App\Models\AnnouncementDetail as AnnouncementDetailModel;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class CategoriesWired extends Component
{
    use WithPagination;
    // public $categories;

    protected $listeners = ['confirm_delete_category_alert',];
    protected $paginationTheme = 'bootstrap';
    public $moment_img_path = 'moment_imgs';
    public $announcement_images = "announcement_imgs";



    public $addNewCategory;
    public $inputs = [];
    public $category_id;
    public $btn_text;
    protected $rules = [
        'name' => 'required',
        'status' => 'required',

    ];
      private function array_to_object($array){
        return (object) $array;

    }

    public function submit_add_new_category()
    {
        //status validation not working
        $validated_data = Validator::make($this->inputs, $this->rules)->validate();
        $category=new CategoryModel();
        $validated_data=$this->array_to_object($validated_data);

        $category->name=$validated_data->name;
        $category->status=$this->array_to_object($this->inputs)->status;
        $category->save();
        $this->addNewCategory = false;



        redirect()->back();
        $this->dispatchBrowserEvent('hide_add_category_modal');
        $this->dispatchBrowserEvent('show-success-toast',["success_msg"=>'New Category Added Successfully']);





    }

    public function change_category_status($category_id,$category_status){
        CategoryModel::where(['id'=> $category_id])->update(['status'=>$category_status=="1"?0:1]);
        $this->dispatchBrowserEvent('show-success-toast',["success_msg"=>'Category Status Updated Successfully']);


    }
    public function hide_modal()
    {
        $this->dispatchBrowserEvent('hide_add_category_modal');

    }


    public function new_category()
    {
        // dd('hmm');
        // $this->dispatchBrowserEvent('clear-file-fields');
        // the event above clears the input fields

        $this->addNewCategory = true;
        $this->inputs = [];
        $this->dispatchBrowserEvent('show_add_category_modal');
        // triggering the show-add-product-modal to show  modal
        $this->btn_text = $this->addNewCategory == true ? 'Save' : 'Save Changes';

    }

    public function edit_category($category_id){
        $this->category_id=$category_id;

        $this->addNewCategory = false;
        $this->inputs = CategoryModel::where(['id'=> $category_id])->first()->toArray();
        $this->dispatchBrowserEvent('show_add_category_modal');
        $this->btn_text = $this->addNewCategory == true ? 'Save' : 'Save Changes';


    }
    public function delete_category($category_id){
        $this->category_id=$category_id;
        $this->dispatchBrowserEvent('show_delete_category_alert');



    }
    public function update_category(){
        $validated_data = Validator::make($this->inputs, $this->rules)->validate();
        CategoryModel::where(['id'=> $this->category_id])->update($validated_data);
        $this->dispatchBrowserEvent('hide_add_category_modal');
        $this->dispatchBrowserEvent('show-success-toast',["success_msg"=>' Category Updated Successfully']);



    }
    public function remove_moment_img_perm($key_moment_id)
    {
        $img_obj = AnnouncementDetailModel::findOrFail($key_moment_id);
        if(!empty($img_obj->image)){

        Storage::disk('public')->delete($this->moment_img_path . '/' . $img_obj->image);
        }

    }
    public function delete_announcement($announcement_id)
    {
        $announcement = AnnouncementModel::with(['get_announcement_key_moments'])->where(['id' => $announcement_id])->first();
    //    dd($announcement);
        $announcement_key_moments = $announcement['get_announcement_key_moments'];
        foreach ($announcement_key_moments as $key_moment) {
            $this->confirm_delete_key_moment($key_moment);

        }
        if(!empty( $announcement->featured_image)){
            Storage::disk('public')->delete($this->announcement_images . '/' . $announcement->featured_image);
        }

        $announcement->delete();


    }
    public function confirm_delete_key_moment($key_moment)
    {

        if (!empty($this->array_to_object($key_moment)->image)) {
            //if this keymoment has an image, I am deleting it before proceeding...

            $moment_id = $this->array_to_object($key_moment)->id;
            $this->remove_moment_img_perm($moment_id);

        }
        AnnouncementDetailModel::findOrFail($key_moment->id)->delete();

    }



    public function confirm_delete_category_alert(){
        // dd(CategoryModel::with(['get_category_announcements'])->get()->toArray());
        $categories=CategoryModel::with(['get_category_announcements'])->get()->all();
        foreach($categories as $category){
            // before deleting a category
            $category_announcements=$category['get_category_announcements'];
            foreach($category_announcements as $category_announcement){
                $this->delete_announcement($category_announcement->id);
                // try and access its announcements and delete its contents(announcement and key moments)

        }
        }


        CategoryModel::findOrFail($this->category_id)->delete();
        $this->dispatchBrowserEvent('show-success-toast',["success_msg"=>' Category Deleted Successfully']);


    }




    public function render()
    {
    $categories = CategoryModel::latest()->paginate(50);

        return view('livewire.admin.announcements.categories-wired')
        ->with(compact('categories'));

    }
}