// To use Html5Qrcode (more info below)
// let cameraId;
// let elemOptionCamera = $("#cam");

// $(document).ready(function () {
// loadCameras();
// $("#scanner").on("click", function(event){
//   event.preventDefault();
//   cameraId = elemOptionCamera.val();
//   initReader(cameraId);
// });
// });

class BarcodeReader {
    constructor() {
        this.cameraId;
        this.implementor;
        this.$option_camera = $("#cam");
        this.$scanner = $("#scanner");
        this.$item_code = $("#item_code");

        this.loadCameras();
        this.triggerEvents();
    }

    triggerEvents() {
        this.$scanner.on("click", this.initReader);
    }

    loadCameras() {
        Html5Qrcode.getCameras()
            .then((devices) => {
                /**
                 * devices would be an array of objects of type:
                 * { id: "id", label: "label" }
                 */
                if (devices && devices.length) {
                    let cameras = "<option value='0'>Select Camera</option>";
                    devices.forEach(function (Camera) {
                        cameras += `<option value="${Camera.id}">${Camera.label}</option>`;
                    });
                    _this.$option_camera.html(cameras);

                    // .. use this to start scanning.
                    // initReader(cameraId);
                }
            })
            .catch((err) => {
                // handle err
            });
    }

    initReader(event) {
        console.log('initReader');
        event.preventDefault();
        _this.cameraId = _this.$option_camera.val();
        const html5QrCode = new Html5Qrcode(/* element id */ "reader");
        html5QrCode
            .start(
                _this.cameraId,
                {
                    fps: 60, // Optional, frame per seconds for qr code scanning
                    qrbox: { width: 120, height: 75 }, // Optional, if you want bounded box UI
                    class: "rounded-2",
                },
                (decodedText, decodedResult) => {
                    // do something when code is read
                    console.log("scan successful: " + decodedText);
                    let defer = $.Deferred(),
                        filtered = defer
                        .then(function () {
                            _this.then_callback(decodedText);
                        });
                        
                    defer.resolve();
                    filtered.done(function(){                        
                        _this.done_callback();
                    });
                },
                (errorMessage) => {
                    // parse error, ignore it.
                }
            )
            .catch((err) => {
                // Start failed, handle it.
            });

    }

    /**
     * .then Callbacks
     */
    changeItemCode(decodedText){
        _this.$item_code.val(decodedText);
    }

    changeSearch(decodedText){
        _this.$search.val(decodedText);
    }
}

export let objBarcodeReader = new BarcodeReader();
let _this = objBarcodeReader;
