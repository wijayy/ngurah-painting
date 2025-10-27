<?php

namespace App\Livewire\Driver;

use App\Models\Driver;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\ImageManager;

class Create extends Component
{
    use WithFileUploads;
    public $password_confirmation = '', $driver, $title, $email, $nomor_telepon, $preview_ktp, $preview_sim, $foto_ktp, $foto_sim;

    #[Validate(rule: 'required|string', as: 'nama')]
    public $name = '';

    public function rules()
    {
        return [
            'password' => $this->driver
                ? 'string|nullable|confirmed'
                : 'string|required|confirmed',

            'email' => $this->driver
                ? ['required', 'email', Rule::unique('users', 'email')->ignore($this->driver->id)]
                : ['required', 'email', Rule::unique('users', 'email')],

            'nomor_telepon' => $this->driver
                ? ['required', 'string', 'starts_with:62', Rule::unique('users', 'nomor_telepon')->ignore($this->driver->id)]
                : ['required', 'string', 'starts_with:62', Rule::unique('users', 'nomor_telepon')],

            'foto_ktp' => $this->driver
                ? 'nullable' // Saat edit dan tidak ada file baru, lewati validasi gambar
                : 'required|image|max:5120', // Wajib saat buat baru, atau validasi jika ada file baru saat edit

            'foto_sim' => $this->driver
                ? 'nullable'
                : 'required|image|max:5120',
        ];
    }
    public $password = '';

    // DRIVER SPECIFIC
    #[Validate('required')]
    public $role = 'driver', $membership_no, $token, $sim_berlaku_hingga = '', $alamat = '';

    #[Validate('required|string')]
    public $no_ktp = '', $bank = '', $nama_rekening = '', $nomor_rekening = '', $no_sim = '', $status = 'aktif';

    public function mount($slug = null)
    {
        // dd(Hash::make(''));
        $this->driver = User::where('slug', $slug)->first();

        if ($slug && $this->driver == null) {
            return redirect(route('driver.index'));
        }

        if ($this->driver) {
            $this->title = "Edit Driver";
            $this->name = $this->driver->name;
            $this->email = $this->driver->email;
            $this->nomor_telepon = $this->driver->nomor_telepon;
            $this->no_ktp = $this->driver->driver->no_ktp;
            $this->bank = $this->driver->driver->bank;
            $this->nama_rekening = $this->driver->driver->nama_rekening;
            $this->nomor_rekening = $this->driver->driver->nomor_rekening;
            $this->no_sim = $this->driver->driver->no_sim;
            $this->status = $this->driver->driver->status;
            $this->preview_ktp = $this->driver->driver->foto_ktp;
            $this->preview_sim = $this->driver->driver->foto_sim;
            $this->sim_berlaku_hingga = $this->driver->driver->sim_berlaku_hingga->format('Y-m-d');
            $this->membership_no = $this->driver->driver->membership_no;
            $this->token = $this->driver->driver->token;
            $this->alamat = $this->driver->driver->alamat;
            $this->nomor_telepon = $this->driver->driver->nomor_telepon;
        } else {
            $this->membership_no = Driver::memberNumberGenerator();
            $this->token = Driver::generateToken();
            $this->title = "Tambah Driver";
        }
    }

    public function save()
    {
        // $validated = $this->validate();


        try {
            DB::beginTransaction();

            $validated = $this->validate();
            // dd('');

            // dd($validated);

            if ($this->driver) {
                // If editing an existing user
                if (empty($validated['password'])) {
                    // If password is empty, remove it from the validated data to avoid overwriting
                    unset($validated['password']);
                } else {
                    // Hash the new password
                    $validated['password'] = Hash::make($validated['password']);
                }
                $this->driver->update($validated);
                // session()->flash('success', "Staff {$this->user->name} has been updated.");
            } else {
                // If creating a new user, hash the password
                $validated['password'] = Hash::make($validated['password']);
                event(new Registered(($user = User::create($validated))));
                // session()->flash('success', "Say hello to our new teammate, $this->name!");
            }

            $foto_ktp_path = $this->driver ? $this->driver->driver->foto_ktp : null;
            if ($this->foto_ktp) {
                // Hapus file lama jika ada (saat edit)
                if ($this->driver && $this->driver->driver->foto_ktp && Storage::disk('public')->exists($this->driver->driver->foto_ktp)) {
                    Storage::disk('public')->delete($this->foto_ktp);
                }

                // Buat instance manager dengan driver GD
                $manager = new ImageManager(GdDriver::class);

                // Baca file dan kompres
                $image = $manager->read($this->foto_ktp->getRealPath())->toJpeg(70);

                // Simpan file yang sudah dikompres
                $foto_ktp_path = 'driver/ktp_' . time() . '.jpg';
                Storage::disk('public')->put($foto_ktp_path, (string) $image);
            }

            $foto_sim_path = $this->driver ? $this->driver->driver->foto_sim : null;
            if ($this->foto_sim) {
                // Hapus file lama jika ada (saat edit)
                if ($this->driver && $this->driver->driver->foto_sim && Storage::disk('public')->exists($this->driver->driver->foto_sim)) {
                    Storage::disk('public')->delete($this->foto_sim);
                }

                $manager = new ImageManager(GdDriver::class);
                $image = $manager->read($this->foto_sim->getRealPath())->toJpeg(70);

                $foto_sim_path = 'driver/sim_' . time() . '.jpg';
                Storage::disk('public')->put($foto_sim_path, (string) $image);
            }

            $driverData = [
                'no_ktp' => $this->no_ktp,
                'bank' => $this->bank,
                'nama_rekening' => $this->nama_rekening,
                'nomor_rekening' => $this->nomor_rekening,
                'no_sim' => $this->no_sim,
                'status' => $this->status,
                'foto_ktp' => $foto_ktp_path,
                'foto_sim' => $foto_sim_path,
                'sim_berlaku_hingga' => $this->sim_berlaku_hingga,
                'membership_no' => $this->membership_no,
                'nomor_telepon' => $this->nomor_telepon,
                'token' => $this->token,
                'alamat' => $this->alamat,
            ];

            if ($this->driver) {
                $this->driver->driver->update($driverData);
                $user = $this->driver;
            } else {
                $driverData['user_id'] = $user->id;
                Driver::create($driverData);
            }

            DB::commit();
            session()->flash('success', "Yey! $user->name is on their way with customer money – no need to chase, it's coming to you!");
            return redirect(route('driver.index'));
        } catch (\Throwable $th) {
            DB::rollBack();
            if (config('app.debug') == true) {
                // session()->flash('error', $th->getMessage());
                throw $th;
            } else {
                return back()->with('error', $th->getMessage());
            }
        }
    }
    // #[Layout('components.layouts.app', ['title' => "Add Driver"])]
    public function render()
    {
        return view('livewire.driver.create')->layout('components.layouts.app', ['title' => $this->title]);
    }
}
