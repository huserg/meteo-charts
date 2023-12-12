<?php

namespace App\View\Components;

use App\Models\Device;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DeviceInfoCard extends Component
{
    /**
     * Create a new component instance.
     */
    public Device $device;

    public function __construct(Device $device)
    {
        $this->device = $device;
        $this->device->load('owner');
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.device-info-card');
    }

    /*
    * alert with swal2 for deleting device
     *
    */
    public function deleteDeviceAlert(): string
    {
        $title = __("Delete :device ?", ['device' => $this->device->name]);
        $text = __("You won't be able to revert this!");
        $confirmButtonText = __("Yes, delete it!");
        $cancelButtonText = __("No, keep it!");
        $cancelled = __("Cancelled");
        $deviceIsSafe = __("Your device is safe :)");

        return <<<JS
        <script>
            document.querySelector('#delete-device-{$this->device->id}').addEventListener('click', function () {
                Swal.fire({
                    title: "$title",
                    text: "$text",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: "$confirmButtonText",
                    cancelButtonText: "$cancelButtonText"
                    }).then((result) => {
                    if (result.isConfirmed) {
                        document.querySelector('#delete-device-form').submit();
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        Swal.fire({
                            timer: 1500,
                            title: "$cancelled",
                            text: "$deviceIsSafe",
                            icon: 'error'
                        }).then(r => r.dismiss === Swal.DismissReason.backdrop)
                    }
                })
            });
        </script>
        JS;
    }

}
