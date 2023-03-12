<?php

namespace App\Http\Livewire\Admin\Announcements;

use App\Models\Announcement as AnnouncementModel;
use App\Models\AnnouncementDetail as AnnouncementDetailModel;
use App\Models\Category as CategoryModel;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
use Livewire\Component;
use Livewire\WithFileUploads;

class AnnouncementsWired extends Component
{
    use WithFileUploads;

    public $addNewAnnouncement;
    public $inputs = [];
    public $announcement_images = "announcement_imgs";

    public $announcement_id;
    public $btn_text;
    protected $listeners = ['confirm_delete_announcement_alert', 'confirm_announcement_img_delete'];

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'title' => 'required|min:30|unique:announcements',
        'category_id' => 'required|numeric',
        'status' => 'required',
        'featured_image' => 'required|image',

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

    public function confirm_delete_announcement_alert()
    {
        $announcement = AnnouncementModel::with(['get_announcement_key_moments'])->where(['id' => $this->announcement_id])->first();
        $announcement_key_moments = $announcement['get_announcement_key_moments'];
        foreach ($announcement_key_moments as $key_moment) {
            $this->confirm_delete_key_moment($key_moment);

        }
        if (!empty($announcement->featured_image)) {
            Storage::disk('public')->delete($this->announcement_images . '/' . $announcement->featured_image);
        }

        $announcement->delete();
        $this->dispatchBrowserEvent('show-success-toast', ["success_msg" => ' announcement Deleted Successfully']);

    }
    public function remove_moment_img_perm($key_moment_id)
    {
        $img_obj = AnnouncementDetailModel::findOrFail($key_moment_id);

        if (!empty($img_obj->image)) {

            Storage::disk('public')->delete($this->moment_img_path . '/' . $img_obj->image);
        }

    }
    public function hide_modal()
    {
        $this->dispatchBrowserEvent('hide_add_announcement_modal');

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

    private function array_to_object($array)
    {
        return (object) $array;

    }
    private function object_to_array($object)
    {
        return (array) $object;

    }
    // method for writing images and returning just its name

    public function store_pic($media_file, $file_name = null)
    {
        $microtime = microtime(true);
        $uploaded_img_path = public_path() . '\\storage\\' . $this->announcement_images . '\\';

        $file_name = $file_name ?? Str::random(5) . '-' . (string) $microtime;
        // generated a random file  for image to be uploaded

        if (!File::exists($uploaded_img_path)) {
            // checking if path to this image file exsists and creating a foldeer for it if it doesnt exsist
            File::makeDirectory($uploaded_img_path);
        }

        if (!empty($media_file)) {
            $file_ext = $media_file->getClientOriginalExtension();
            $new_file_name = 'announcement_img' . "_" . $file_name . "_." . $file_ext;

            $img = Image::make($media_file);
            $img->save($uploaded_img_path . $new_file_name);

        }
        return $new_file_name;

    }
    public function clear_temp_img()
    {
        $this->inputs['featured_image'] = "";
    }
    public function clear_db_img($announcement_id)
    {
        $this->announcement_id = $announcement_id;
        $this->dispatchBrowserEvent('announcement_img_delete');

    }
    public function confirm_announcement_img_delete($show_msg = true)
    {
        $img_obj = AnnouncementModel::findOrFail($this->announcement_id);
        AnnouncementModel::where('id', $this->announcement_id)->update(["featured_image" => ""]);

        Storage::disk('public')->delete($this->announcement_images . '/' . $img_obj->featured_image);

        if ($show_msg == true) {
            $this->dispatchBrowserEvent('show-success-toast', ["success_msg" => "featured  image removed successfully!"]);

        }
        $this->dispatchBrowserEvent('hide_add_announcement_modal');

    }
    public function update_announcement()
    {
        $announcement = AnnouncementModel::where(['id' => $this->announcement_id])->first();

        if (!empty($announcement->featured_image) && is_string($announcement->featured_image)) {
            $this->rules['featured_image'] = '';

        }
        $validated_data = Validator::make($this->inputs, $this->rules)->validate();
        $validated_data = $this->array_to_object($validated_data);
        if (is_object($validated_data->featured_image)) {
            //new  image is set

            //  check and delete old announcement image before adding new one
            $featured_image = $announcement->featured_image;
            if (!empty($featured_image)) {
                Storage::disk('public')->delete($this->announcement_images . '/' . $announcement->featured_image);

            }

            $validated_data->featured_image = $this->store_pic($validated_data->featured_image);

        }

        AnnouncementModel::where(['id' => $this->announcement_id])->update($this->object_to_array($validated_data));
        $this->dispatchBrowserEvent('hide_add_announcement_modal');
        $this->dispatchBrowserEvent('clear_file_fields');
        $this->inputs = [];

        $this->dispatchBrowserEvent('show-success-toast', ["success_msg" => ' announcement Updated Successfully']);

    }
    public function submit_add_new_announcement()
    {

        //status validation not working
        $validated_data = Validator::make($this->inputs, $this->rules)->validate();

        $announcement = new AnnouncementModel();
        $validated_data = $this->array_to_object($validated_data);
        if (is_object($validated_data->featured_image)) {
            // image is set
            $announcement->featured_image = $this->store_pic($validated_data->featured_image);

        }

        $announcement->title = $validated_data->title;
        $announcement->category_id = $validated_data->category_id;
        $announcement->status = $this->array_to_object($this->inputs)->status;
        $announcement->save();
        $this->addNewAnnouncement = false;
        $this->dispatchBrowserEvent('clear_file_fields');
        $this->inputs = [];

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

        return view('livewire.admin.announcements.announcements-wired')->with(compact('announcements', 'categories'));
    }
}