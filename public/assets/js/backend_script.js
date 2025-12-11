// const { data } = require("autoprefixer");

var global_permission_state = 0;

var state_password_show = 0;
function show_password() {
    if (state_password_show == 0) {
        document.querySelector("#password").setAttribute("type", "text");
        state_password_show++;
    } else {
        document.querySelector("#password").setAttribute("type", "password");
        state_password_show = 0;
    }
}
var permission_state = 0;
function change_permission() {
    if (permission_state == 0) {
        permission_state++;
    }
}

function form_submit() {
    let form = document.querySelector("#user_form");

    if (form.checkValidity()) {
        if (permission_state == 0) {
            document.querySelector(".toast_position").style.display = "block";
            permission_state = 1;
        } else {
            form.submit();
        }
    } else {
        form.reportValidity(); // This will show the validation messages
    }
}

function cancel_toast(toast) {
    document.querySelector("#" + toast).style.display = "none";
}

var image_show = document.querySelector("#image_show");

var id_box = "box";
var state_box = 1;
function append_img() {
    var newElement = document.createElement("div");

    let box = id_box + state_box;
    newElement.className = "image_box image_box" + state_box;
    newElement.id = "image_box" + state_box;
    newElement.innerHTML = `
                                <img id="${box}" onclick="maximize_minimize(${state_box},0)"  src="/uploads/image/{{ $item->image }}"

                                    alt="Item">


                                <button type="button" id="delete_image" onclick="remove_image(${state_box})"><i class="fa-solid fa-trash"
                                        style="color: #ff0000;"></i>


                                <a download="${item.image}" href="/uploads/image/${item.image}"><button
                                        type="button" id="download_image"><i class="fa-regular fa-circle-down"
                                            style="color: #71bd00;"></i></button></a>
                                <input id="input${state_box}"  type="file"
                                    onchange="onchnage_imgae(event,${state_box})"  name="image${state_box}" class="hidden">





  `;

    // Append image
    image_show.append(newElement);

    // Click Current Input
    document.querySelector("#input" + state_box).click();

    // Assign Value to  input text as state
    document.querySelector("#image_state").value += state_box;

    // Transfer value to Image

    state_box++;
}

var input_box = document.querySelector(".file_input");

function onchnage_imgae(event, boxNo) {
    let filName = document.querySelector("#input" + boxNo).files.item(0).name;
    let extension = filName.split(".").pop();

    if (
        extension == "jpg" ||
        extension == "jpeg" ||
        extension == "gif" ||
        extension == "png"
    ) {
        var reader = new FileReader();
        reader.onload = function () {
            var output = document.getElementById("box" + boxNo);
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    } else {
        document.querySelector("#image_box" + boxNo).remove();
        state_box--;
        document.querySelector("#image_state").value = state_box;
        alert("File is Unknown! , FIle allow is  JPG  JPEG  GIF PNG");
    }
}
function maximize_minimize(id, state) {
    let imgElement =
        state === 0
            ? document.querySelector("#box" + id)
            : document.querySelector("#" + id);

    if (!imgElement) return;

    const url = imgElement.src;
    const newWindow = window.open("", "_blank");

    newWindow.document.write(`
        <html>
        <head>
            <title>Smooth Image Zoom</title>
            <style>
                body {
                    margin:0;
                    background:black;
                    display:flex;
                    justify-content:center;
                    align-items:center;
                    height:100vh;
                    overflow:hidden;
                }
                #zoom-img {
                    max-width:90vw;
                    max-height:90vh;
                    cursor:crosshair;
                }
                .zoom-lens {
                    position:absolute;
                    border: 4px solid #4b6cb7;
                    border-radius:50%;
                    width:250px;
                    height:250px;
                    pointer-events:none;
                    background-repeat:no-repeat;
                    background-size:cover;
                    display:none;
                    z-index:1000;
                    transition: all 0.1s ease-out;
                }
            </style>
        </head>
        <body>
            <img id="zoom-img" src="${url}" />
            <div class="zoom-lens" id="zoom-lens"></div>
            <script>
                const img = document.getElementById('zoom-img');
                const lens = document.getElementById('zoom-lens');

                let targetX = 0, targetY = 0;
                let currentX = 0, currentY = 0;

                // Smooth scroll zoom
                let targetZoom = 2;
                let currentZoom = 2;
                const zoomStep = 0.2;
                const minZoom = 1;
                const maxZoom = 5;

                img.addEventListener('mousemove', e => {
                    const rect = img.getBoundingClientRect();
                    targetX = e.clientX - rect.left;
                    targetY = e.clientY - rect.top;
                    lens.style.display = 'block';
                });

                img.addEventListener('mouseleave', () => lens.style.display = 'none');

                img.addEventListener('wheel', e => {
                    e.preventDefault();
                    targetZoom += e.deltaY < 0 ? zoomStep : -zoomStep;
                    targetZoom = Math.max(minZoom, Math.min(maxZoom, targetZoom));
                });

                function animateLens() {
                    // Smooth position
                    currentX += (targetX - currentX) * 0.15;
                    currentY += (targetY - currentY) * 0.15;

                    // Smooth zoom
                    currentZoom += (targetZoom - currentZoom) * 0.1;

                    const rect = img.getBoundingClientRect();
                    const pageX = rect.left + currentX;
                    const pageY = rect.top + currentY;

                    lens.style.left = (pageX - lens.offsetWidth/2) + 'px';
                    lens.style.top = (pageY - lens.offsetHeight/2) + 'px';

                    lens.style.backgroundImage = 'url(${url})';
                    lens.style.backgroundSize = img.width * currentZoom + 'px ' + img.height * currentZoom + 'px';
                    lens.style.backgroundPosition = (-currentX * currentZoom + lens.offsetWidth/2) + 'px ' + (-currentY * currentZoom + lens.offsetHeight/2) + 'px';

                    requestAnimationFrame(animateLens);
                }

                animateLens();
            </script>
        </body>
        </html>
    `);

    newWindow.document.close();
}

function remove_image(id) {
    document.querySelector("#image_box" + id).remove();
    state_box--;
    document.querySelector("#image_state").value = state_box;
}

var state_doc = 1;

function append_file() {
    var container_file = document.querySelector("#container_file");
    let newElementFile = document.createElement("div");

    // Assign Class Name to content
    newElementFile.className = "file_document";
    // Assign ID to new Content
    newElementFile.id = "document" + state_doc;

    // Input Content
    newElementFile.innerHTML = `
          <button type="button" class="flex justify-center items-center">
                    <i  id="icon${state_doc}"></i>
                    <span class="px-5" id="text_title${state_doc}">File.txt</span>
                    <input type="file" id="doc${state_doc}" onchange="change_doc(${state_doc})" name="file_doc${state_doc}"  class="hidden">
                </button>
    `;

    // Append Child Input
    container_file.append(newElementFile);

    // Auto Click file to choose file
    document.querySelector("#doc" + state_doc).click();

    // Assign Value to state DOc
    document.querySelector("#file_state").value = state_doc;

    // Increase State for new input
    state_doc++;
}

function change_doc(id) {
    let spanTitle = document.querySelector("#text_title" + id);
    let filName = document.querySelector("#doc" + id).files.item(0).name;
    let icon = document.querySelector("#icon" + id);

    spanTitle.textContent = filName;

    let extension = filName.split(".").pop();

    if (extension == "xlsx") {
        icon.innerHTML = ` <i class="fa-solid fa-file-excel" style=" color: #009d0a;"></i>`;
    } else if (extension == "pdf") {
        icon.innerHTML = `<i class="fa-solid fa-file-pdf" style="color: #ff0000;"></i>`;
    } else if (extension == "pptx") {
        icon.innerHTML = `           <i class="fa-solid fa-file-powerpoint" style="color: #ff6600;"></i>`;
    } else if (extension == "docx") {
        icon.innerHTML = ` <i class="fa-solid fa-file-word" style="color: #004dd1;"></i>`;
    } else if (extension == "zip" || extension == "rar") {
        icon.innerHTML = `<i class="fa-solid fa-file-zipper" style="color: #000000;"></i>`;
    } else {
        let input_box = document.querySelector("#document" + id);
        input_box.remove();

        state_doc--;
        document.querySelector("#file_state").value = state_doc;
        alert(
            "File is Unknown! , FIle allow is  PDF , PPTX, DOCX , ZIP , RAR."
        );
    }
}

function remove_file_container(id) {
    document.querySelector("#file_container" + id).remove();
}

function logout() {
    //  Toast Show

    document.querySelector("#logout").style.display = "block";

    // assign value to input
    document.querySelector("#" + toast_input).value = id;
}

function remove(box) {
    document.querySelector("#" + box).remove();
}

function change_form_attribute() {
    let form = document.querySelector("#form-submit");
    console.log(form);
    form.setAttribute("action", "/admin/assets/restore");
    form.submit();
}
var data_invoice;
async function search_assets() {
    let id = document.querySelector("#asset_Code1").value;

    if (id) {
        let url = `/api/assets/${id}`;

        let data = await fetch(url, {
            method: "GET",
            headers: {
                Authorization: `Bearer ${token}`,
                "Content-Type": "application/json",
            },
        })
            .then((response) => {
                if (!response.ok) {
                    console.log(2);
                    throw new Error("Network response was not ok");
                }
                return response.json(); // Expecting JSON
            })
            .then((data) => {
                return data; // Handle your data
            })
            .catch((error) => {
                console.log(3);
                console.error(
                    "There was a problem with the fetch operation:",
                    error
                );
            });

        if (data) {
            if (data.length == 1) {
                let assetCodeAccount = document.querySelector(
                    "#asset_code_account"
                );

                if (assetCodeAccount) assetCodeAccount.value = data[0].assets;

                let postingDate = document.querySelector(
                    "#invoice_posting_date"
                );
                if (postingDate) postingDate.value = data[0].posting_date;

                let faInvoice = document.querySelector("#fa_invoice");
                if (faInvoice) faInvoice.value = data[0].invoice_no;

                let fa = document.querySelector("#fa");
                if (fa) fa.value = data[0].fa;

                let faClass = document.querySelector("#fa_class");
                if (faClass) faClass.value = data[0].fa_class_code;

                let faSubclass = document.querySelector("#FA_Subclass_Code");
                if (faSubclass) faSubclass.value = data[0].fa_subclass;

                let faPostingType = document.querySelector("#fa_posting_type");
                if (faPostingType) faPostingType.value = data[0].type;

                let cost = document.querySelector("#cost");
                if (cost) cost.value = parseFloat(data[0].cost);

                let vat = document.querySelector("#vat");
                let vat_value = "";
                if (data[0].vat == 0) {
                    vat_value = "VAT 0";
                } else if (data[0].vat == 10) {
                    vat_value = "VAT 10";
                }

                if (vat) vat.value = vat_value;

                let currency = document.querySelector("#currency");
                if (currency) currency.value = data[0].currency;

                let description = document.querySelector("#description");
                if (description) description.value = data[0].fa_description;

                let depreciation_book_code = document.querySelector(
                    "#depreciation_book_code"
                );
                if (depreciation_book_code)
                    depreciation_book_code.value = data[0].depreciation;

                let invoice_description = document.querySelector(
                    "#invoice_description"
                );
                if (invoice_description)
                    invoice_description.value = data[0].description;

                let vendor = document.querySelector("#vendor");
                if (vendor) vendor.value = data[0].vendor;

                let vendorName = document.querySelector("#vendor_name");
                if (vendorName) vendorName.value = data[0].vendor_name;

                let address = document.querySelector("#address");
                if (address) address.value = data[0].Address;

                let address2 = document.querySelector("#address2");
                if (address2) address2.value = data[0].address2;

                let contact = document.querySelector("#contact");
                if (contact) contact.value = data[0].Contact;

                let phone = document.querySelector("#phone");
                if (phone) phone.value = data[0].phone;

                let email = document.querySelector("#email");
                if (email) email.value = data[0].email;

                let faLocation = document.querySelector("#fa_location");
                if (faLocation) faLocation.value = data[0].fa_location;

                let assets = document.querySelector("#asset_Code1");

                if (assets) assets.value = data[0].assets;

                alert("Fill Data Success.");
            } else if (data.length > 1) {
                data_invoice = await data;
                let table_select_assets =
                    document.querySelector(".table_select");
                if (table_select_assets) {
                    table_select_assets.style.display = "block";
                    table_select_assets.innerHTML = `
                    <div class="align_right"><span>Existing Invoice in Current Assets</span><button onclick="close_table()" type="button" class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 shadow-lg shadow-red-500/50 dark:shadow-lg dark:shadow-red-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Close</button> </div>
                    <div class="inner-data dark:bg-gray-900">

                    <table id="table_selec_asset" class="w-full overflow-auto  text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-white dark:bg-gray-700 dark:text-gray-400">
                            <tr   tabindex="0">
                                <th scope="col" class="px-1 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2">Posting Date</th>
                                <th scope="col" class="px-1 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2">Assets</th>
                                <th scope="col" class="px-1 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2">FA</th>
                                <th scope="col" class="px-1 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2">Invoice No</th>
                                <th scope="col" class="px-1 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2">Description</th>
                                <th scope="col" class="px-1 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2">Invoice Description</th>
                                <th scope="col" class="px-1 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2">Cost</th>
                                <th scope="col" class="px-1 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2">Currency</th>
                                <th scope="col" class="px-1 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2">Action</th>
                            </tr>
                        </thead>
                  <tbody class="sticky top-0">
    ${data
        .map(
            (item, index) => `
            <tr   tabindex="0" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">

                <td class="px-1 py-1 lg:px-6 lg:py-4 md:px-4 md:py-2">
                    ${
                        item.posting_date
                            ? new Date(item.posting_date).toLocaleDateString(
                                  "en-US",
                                  {
                                      year: "numeric",
                                      month: "short",
                                      day: "numeric",
                                  }
                              )
                            : ""
                    }
                </td>

                <td class="px-1 py-1 lg:px-6 lg:py-4 md:px-4 md:py-2 no_wrap">
                    ${item.assets || ""}
                </td>

                <td class="px-1 py-1 lg:px-6 lg:py-4 md:px-4 md:py-2 no_wrap">
                    ${item.fa || ""}
                </td>

                <td class="px-1 py-1 lg:px-6 lg:py-4 md:px-4 md:py-2 no_wrap">
                    ${item.invoice_no || ""}
                </td>

                <td class="px-1 py-1 lg:px-6 lg:py-4 md:px-4 md:py-2">
                    ${item.description || ""}
                </td>

                <td class="px-1 py-1 lg:px-6 lg:py-4 md:px-4 md:py-2">
                    ${item.fa_description || ""}
                </td>

                <td class="px-1 py-1 lg:px-6 lg:py-4 md:px-4 md:py-2">
                    ${
                        item.cost !== undefined && item.cost !== null
                            ? parseFloat(item.cost)
                            : ""
                    }
                </td>

                <td class="px-1 py-1 lg:px-6 lg:py-4 md:px-4 md:py-2">
                    ${item.currency || ""}
                </td>

                <td class="px-1 py-1 lg:px-6 lg:py-4 md:px-4 md:py-2">
                    <button
                        type="button"
                        onclick="assets_invoice_choose(${index})"
                        class="scale-50 lg:scale-100 text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 shadow-lg shadow-purple-500/50 dark:shadow-lg dark:shadow-purple-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                        Select
                    </button>
                </td>

            </tr>
        `
        )
        .join("")}
</tbody>

                    </table>
                     </div>
                `;
                }
            } else if (data.length == 0) {
                alert("Data not Found");
            }
        } else {
            alert("Error This function is cant be used.");
        }
    } else {
        let label = document.querySelector("#assets_label");
        label.innerHTML = `Asset Code  (Required)`;
        label.style.color = "red";
        alert("Asset Code  (Required)");
    }
}
function assets_invoice_choose(index) {
    let assetCodeAccount = document.querySelector("#asset_code_account");

    if (assetCodeAccount) assetCodeAccount.value = data_invoice[index].assets;

    let postingDate = document.querySelector("#invoice_posting_date");
    if (postingDate) postingDate.value = data_invoice[index].posting_date;

    let faInvoice = document.querySelector("#fa_invoice");
    if (faInvoice) faInvoice.value = data_invoice[index].invoice_no;

    let fa = document.querySelector("#fa");
    if (fa) fa.value = data_invoice[index].fa;

    let faClass = document.querySelector("#fa_class");
    if (faClass) faClass.value = data_invoice[index].fa_class_code;

    let faSubclass = document.querySelector("#FA_Subclass_Code");
    if (faSubclass) faSubclass.value = data_invoice[index].fa_subclass;

    let faPostingType = document.querySelector("#fa_posting_type");
    if (faPostingType) faPostingType.value = data_invoice[index].type;

    let cost = document.querySelector("#cost");
    if (cost) cost.value = parseFloat(data_invoice[index].cost || 0);

    let vat = document.querySelector("#vat");
    let vat_value = "";
    if (data_invoice[index].vat == 0) {
        vat_value = "VAT 0";
    } else if (data_invoice[index].vat == 10) {
        vat_value = "VAT 10";
    }

    if (vat) vat.value = vat_value;

    let currency = document.querySelector("#currency");
    if (currency) currency.value = data_invoice[index].currency;

    let description = document.querySelector("#description");
    if (description) description.value = data_invoice[index].fa_description;

    let depreciation_book_code = document.querySelector(
        "#depreciation_book_code"
    );
    if (depreciation_book_code)
        depreciation_book_code.value = data_invoice[index].depreciation;

    let invoice_description = document.querySelector("#invoice_description");
    if (invoice_description)
        invoice_description.value = data_invoice[index].description;

    let vendor = document.querySelector("#vendor");
    if (vendor) vendor.value = data_invoice[index].vendor;

    let vendorName = document.querySelector("#vendor_name");
    if (vendorName) vendorName.value = data_invoice[index].vendor_name;

    let address = document.querySelector("#address");
    if (address) address.value = data_invoice[index].Address;

    let address2 = document.querySelector("#address2");
    if (address2) address2.value = data_invoice[index].address2;

    let contact = document.querySelector("#contact");
    if (contact) contact.value = data_invoice[index].Contact;

    let phone = document.querySelector("#phone");
    if (phone) phone.value = data_invoice[index].phone;

    let email = document.querySelector("#email");
    if (email) email.value = data_invoice[index].email;

    let faLocation = document.querySelector("#fa_location");
    if (faLocation) faLocation.value = data_invoice[index].fa_location;

    let assets = document.querySelector("#asset_Code1");
    if (assets) assets.value = data_invoice[index].assets;

    let table_select_assets = document.querySelector(".table_select");
    if (table_select_assets) {
        table_select_assets.style.display = "none";
    }

    alert("Fill Data Success.");
}

function close_table() {
    document.querySelector(".table_select").style.display = "none";
}

function remove_image_from_stored_varaint(id) {
    document.querySelector("#image_box_varaint" + id).remove();
    document.querySelector("#image_input_variant_" + id).remove();
}

function select_all_permission() {
    let user_read = document.querySelector("#user_read");
    let user_write = document.querySelector("#user_write");
    let user_update = document.querySelector("#user_update");
    let user_delete = document.querySelector("#user_delete");

    let assets_read = document.querySelector("#assets_read");
    let assets_write = document.querySelector("#assets_write");
    let assets_update = document.querySelector("#assets_update");
    let assets_delete = document.querySelector("#assets_delete");

    let transfer_read = document.querySelector("#transfer_read");
    let transfer_write = document.querySelector("#transfer_write");
    let transfer_update = document.querySelector("#transfer_update");
    let transfer_delete = document.querySelector("#transfer_delete");

    let quick_read = document.querySelector("#quick_read");
    let quick_write = document.querySelector("#quick_write");
    let quick_update = document.querySelector("#quick_update");
    let quick_delete = document.querySelector("#quick_delete");

    let select_all = document.querySelector("#select_all");
    if (select_all) {
        if (select_all.checked == true) {
            if (user_read) {
                user_read.checked = true;
            }
            if (user_write) {
                user_write.checked = true;
            }
            if (user_update) {
                user_update.checked = true;
            }
            if (user_delete) {
                user_delete.checked = true;
            }
            if (assets_read) {
                assets_read.checked = true;
            }
            if (assets_write) {
                assets_write.checked = true;
            }
            if (assets_update) {
                assets_update.checked = true;
            }
            if (assets_delete) {
                assets_delete.checked = true;
            }
            if (transfer_read) {
                transfer_read.checked = true;
            }
            if (transfer_write) {
                transfer_write.checked = true;
            }
            if (transfer_update) {
                transfer_update.checked = true;
            }
            if (transfer_delete) {
                transfer_delete.checked = true;
            }

            if (quick_read) {
                quick_read.checked = true;
            }
            if (quick_write) {
                quick_write.checked = true;
            }
            if (quick_update) {
                quick_update.checked = true;
            }
            if (quick_delete) {
                quick_delete.checked = true;
            }
        } else {
            if (user_read) {
                user_read.checked = false;
            }
            if (user_write) {
                user_write.checked = false;
            }
            if (user_update) {
                user_update.checked = false;
            }
            if (user_delete) {
                user_delete.checked = false;
            }
            if (assets_read) {
                assets_read.checked = false;
            }
            if (assets_write) {
                assets_write.checked = false;
            }
            if (assets_update) {
                assets_update.checked = false;
            }
            if (assets_delete) {
                assets_delete.checked = false;
            }
            if (transfer_read) {
                transfer_read.checked = false;
            }
            if (transfer_write) {
                transfer_write.checked = false;
            }
            if (transfer_update) {
                transfer_update.checked = false;
            }
            if (transfer_delete) {
                transfer_delete.checked = false;
            }

            if (quick_read) {
                quick_read.checked = false;
            }
            if (quick_write) {
                quick_write.checked = false;
            }
            if (quick_update) {
                quick_update.checked = false;
            }
            if (quick_delete) {
                quick_delete.checked = false;
            }
        }
    }
}

function isObject(data) {
    return data !== null && typeof data === "object";
}

function close_modal() {
    document.querySelector("#small-modal").style.display = "none";
}

let state_asset_permission = 1;
let user_permission = 1;
let transfer_permission = 1;
let qucik_data_permission = 1;
function set_permission(type) {
    let read = document.querySelector("#" + type + "_read");
    let write = document.querySelector("#" + type + "_write");
    let update = document.querySelector("#" + type + "_update");
    let delete_type = document.querySelector("#" + type + "_delete");
    let state_all = 1;

    if (type == "assets") {
        if (state_asset_permission == 0) {
            state_all = 0;
            state_asset_permission = 1;
        } else {
            state_all = 1;
            state_asset_permission = 0;
        }
    }
    if (type == "user") {
        if (user_permission == 0) {
            state_all = 0;
            user_permission = 1;
        } else {
            state_all = 1;
            user_permission = 0;
        }
    }
    if (type == "transfer") {
        if (transfer_permission == 0) {
            state_all = 0;
            transfer_permission = 1;
        } else {
            state_all = 1;
            transfer_permission = 0;
        }
    }
    if (type == "quick") {
        if (qucik_data_permission == 0) {
            state_all = 0;
            qucik_data_permission = 1;
        } else {
            state_all = 1;
            qucik_data_permission = 0;
        }
    }
    if (state_all == 1) {
        if (read) {
            read.checked = true;
        }
        if (write) {
            write.checked = true;
        }
        if (update) {
            update.checked = true;
        }
        if (delete_type) {
            delete_type.checked = true;
        }
    } else {
        if (read) {
            read.checked = false;
        }
        if (write) {
            write.checked = false;
        }
        if (update) {
            update.checked = false;
        }
        if (delete_type) {
            delete_type.checked = false;
        }
    }
}
let export_excel = document.querySelector("#export_excel");
let print = document.querySelector("#print");

var k;
function printable() {
    let li_print = document.querySelectorAll(".print_val");
    let li_print_array = Array.from(li_print);

    let length = li_print_array.length;

    li_print_array.map((data) => {
        let input = data.querySelector("input");
        if (input.checked == true) {
            k = length -= 1;
        } else {
            k = length;
        }
    });

    // console.log(k);

    if (k != length) {
        print.style.display = "none";
        export_excel.style.display = "none";
    } else {
        print.style.display = "block";
        export_excel.style.display = "block";
    }
}

function print_group() {
    let li_print = document.querySelectorAll(".print_val");
    let li_print_array = Array.from(li_print);
    let id_for_print = [];
    console.log(li_print_array);
    li_print_array.map((data) => {
        let input = data.querySelector("input");
        if (input.checked == true) {
            let val = input.getAttribute("data-id");
            console.log(val);
            id_for_print.push(val);
        }
    });

    console.log(id_for_print);
    if (id_for_print.length > 0) {
        let id_input = document.querySelector("#id_printer");
        id_input.value = id_for_print;

        let form = document.querySelector("#form_print");

        console.log(form);
        form.submit();
    }
}
let id_for_export = [];
function export_group() {
    let li_print = document.querySelectorAll(".print_val");
    let li_print_array = Array.from(li_print);

    li_print_array.map((data) => {
        let input = data.querySelector("input");
        if (input.checked == true) {
            let val = input.getAttribute("data-id");
            id_for_export.push(val);
        }
    });

    if (id_for_export.length > 0) {
        let input_export = document.querySelector("#id_export");
        input_export.value = id_for_export;

        let form = document.querySelector("#form_export");
        form.submit();
    }
}

function select_all() {
    let select_all_v = document.querySelector("#select_all");
    let input_select = document.querySelectorAll(".select_box");

    if (select_all_v) {
        if (select_all_v.checked == true) {
            if (input_select) {
                let tbody = Array.from(input_select);
                if (tbody) {
                    tbody.map((target) => {
                        if (target) {
                            target.checked = true;
                        }
                    });
                }
            }
        } else {
            if (input_select) {
                let tbody = Array.from(input_select);
                if (tbody) {
                    tbody.map((target) => {
                        if (target) {
                            target.checked = false;
                        }
                    });
                }
            }
        }
    }
    printable();
}

function otherSearch() {
    let other = document.querySelector("#other_search");

    if (other) {
        if (other.value != "") {
            other_search = 1;
        } else {
            other_search = 0;
            alert("Select Field to Search.");
        }
    }
}
const token = localStorage.getItem("token");

let other_search = 0;
async function search_asset(no) {
    // Prevent multiple click
    id_for_export = [];
    let select_all_v = document.querySelector("#select_all");
    select_all_v.checked = false;
    print.style.display = "none";
    export_excel.style.display = "none";

    let department = document.querySelector("#department");
    let asset_input = document.querySelector("#assets");
    let company = document.querySelector("#company");
    let description = document.querySelector("#description");
    let start = document.querySelector("#start_date");
    let end = document.querySelector("#end_date");
    let state = document.querySelector("#state");
    let user = document.querySelector("#user");
    let other = document.querySelector("#other_search");
    let value = document.querySelector("#other_value");

    let user_val = "NA";
    let department_val = "NA";
    let asset_val = "NA";
    let company_val = "NA";
    let description_val = "NA";
    let start_val = "NA";
    let end_val = "NA";
    let state_val = "NA";
    let type_val = "NA";
    let value_val = "NA";

    let page = 1;
    if (no) {
        page = no;
    }
    if (user) {
        if (user.value != "") {
            user_val = user.value;
        }
    }
    if (department) {
        if (department.value != "") {
            department_val = department.value;
        }
    }
    if (asset_input) {
        if (asset_input.value != "") {
            asset_val = asset_input.value;
        }
    }
    if (company) {
        if (company.value != "") {
            company_val = company.value;
        }
    }
    if (description) {
        if (description.value != "") {
            description_val = description.value;
        }
    }
    if (start) {
        if (start.value != "") {
            start_val = start.value;
        }
    }
    if (end) {
        if (end.value != "") {
            end_val = end.value;
        }
    }
    if (state) {
        if (state.value != "") {
            state_val = state.value;
        }
    }

    if (value) {
        if (value.value != "") {
            value_val = value.value;
        }
    }
    if (other) {
        type_val = other.value;
    }

    const url = `/api/fect/asset/data`;
    let data;
    try {
        // Run loader while fetching
        data = await showLoader(async () => {
            const response = await fetch(url, {
                method: "POST",
                headers: {
                    Authorization: `Bearer ${token}`,
                    "Content-Type": "application/json",
                    "Cache-Control": "no-cache",
                    Pragma: "no-cache",
                },
                body: JSON.stringify({
                    type: type_val,
                    value: value_val,
                    user: user_val,
                    state: state_val,
                    asset: asset_val,
                    department: department_val,
                    company: company_val,
                    end: end_val,
                    start: start_val,
                    description: description_val,
                    page: page,
                    _t: Date.now(), // 👈 cache buster
                }),
            });

            return await response.json(); // return the fetched data
        });

        console.log(data); // JSON response is now available
    } catch (error) {
        alert(error);
    }

    let body_change = document.querySelector("#assets_body");
    let pagination_search = document.querySelector(".pagination_by_search");
    if (data) {
        if (data.data) {
            if (data.data.length > 0) {
                if (pagination_search) {
                    pagination_search.style.display = "block";

                    if (data.page != 0) {
                        let page = data.page;
                        let totalPage = data.total_page;
                        let totalRecord = data.total_record;

                        // Start by building the entire HTML content in one go
                        let paginationHtml = `

                                <ul class="flex items-center -space-x-px h-8 text-sm">

                                `;

                        // Add the current page dynamically
                        let left_val = page - 5;
                        if (left_val < 1) {
                            left_val = 1;
                        }
                        if (page != 1 && totalPage != 1) {
                            paginationHtml += `
                                    <li onclick="search_asset(${
                                        page - 1
                                    })"  class="flex items-center justify-center px-1 h-4   lg:px-3 lg:h-8  md:px-1 md:h-4 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">


                                            <i class="fa-solid fa-angle-left"></i>

                                    </li>
                                 `;
                        }
                        let right_val = page + 5;
                        if (right_val > totalPage) {
                            right_val = totalPage;
                        }

                        for (let i = left_val; i <= right_val; i++) {
                            if (i != page) {
                                paginationHtml += `
                                        <li onclick="search_asset(${i})" class="flex items-center justify-center px-1 h-4   lg:px-3 lg:h-8  md:px-1 md:h-4 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                                        >

                                                 ${i}


                                         </li>
                                     `;
                            } else if (i == page) {
                                paginationHtml += `
                                          <li onclick="search_asset(${i})" class="z-10 flex items-center justify-center px-1 h-4   lg:px-3 lg:h-8  md:px-1 md:h-4 leading-tight text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">

                                                ${i}

                                        </li>
                                     `;
                            }
                        }

                        if (page != totalPage) {
                            paginationHtml += `
                                    <li  onclick="search_asset(${
                                        page + 1
                                    })" class="flex items-center justify-center px-1 h-4   lg:px-3 lg:h-8  md:px-1 md:h-4 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">


                                            <i class="fa-solid fa-chevron-right"></i>

                                    </li>
                    `;
                        }

                        paginationHtml += `
                           <li class="mx-2" style="margin-left:10px;">
                                    <a href="${page_view}" aria-current="page"
                                        class="z-10 flex items-center justify-center px-1 h-4   lg:px-3 lg:h-8  md:px-1 md:h-4 leading-tight text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">
                                        <i class="fa-solid fa-filter-circle-xmark" style="color: #ff0000;"></i>
                                    </a>
                                </li>
                                </ul>
                        <select
                            onchange="set_page_dynamic()"
                            id="select_page_dynamic"
                             class="flex  items-center justify-center px-1 h-8   lg:px-3 lg:h-8  md:px-1 md:h-8 text-sm leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                             `;
                        if (page != 1) {
                            paginationHtml += `
                                 <option value="${page}">${page}</option>
                                 `;
                        }

                        for (let i = 1; i <= totalPage; i++) {
                            paginationHtml += `
                                 <option value="${i}">${i}</option>
                                 `;
                        }

                        paginationHtml += `
                                 </select>


                                    <span class="font-bold flex justify-center items-center dark:text-slate-50">Found Page :${totalPage} Pages
                                        &ensp;Total Transaction: ${totalRecord} Records</span>


                                 </div>
                                 `;

                        // Finally, assign the full HTML to the element
                        pagination_search.innerHTML = paginationHtml;
                    }
                }

                body_change.innerHTML = ``;
                data.data.map((item, index) => {
                    let custom = ``;
                    if (item.deleted == 1) {
                        custom += `<tr   tabindex="0" class="deleted_record bg-rose-100 border-b dark:bg-rose-800 dark:border-gray-700">
                                     <td class="print_val  px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                                <input onchange="printable()" data-id="${
                                                    item.assets_id || ""
                                                }" id="green-checkbox${item.id}"
                                                    type="checkbox" value=""
                                                    class="select_box w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                Deleted
                                                    </td>


                        `;
                    } else {
                        custom += `<tr   tabindex="0" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                 <td class="print_val px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                                <input onchange="printable()" data-id="${
                                                    item.assets_id || ""
                                                }" id="green-checkbox${item.id}"
                                                    type="checkbox" value=""
                                                    class="select_box w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            </td>
                        `;
                    }
                    custom += `





                                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                                    ${item.assets_id || ""}
                                                </td>
                                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                               ${
                                                   item.transaction_date
                                                       ? new Date(
                                                             item.transaction_date
                                                         )
                                                             .toLocaleDateString(
                                                                 "en-GB",
                                                                 {
                                                                     day: "2-digit",
                                                                     month: "short",
                                                                     year: "numeric",
                                                                 }
                                                             )
                                                             .replace(/ /g, "-") // replace spaces with dashes
                                                       : ""
                                               }

                                                </td>
                                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                                ${item.assets1 || ""}${
                        item.assets2 || ""
                    }
                                                </td>
                                                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                       ${
                                           item.status == 1
                                               ? `
                                                <span
                                                class="inline-flex items-center bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
                                                <span class="w-2 h-2 me-1 bg-green-500 rounded-full"></span>
                                                Active
                                                </span>
                                            `
                                               : `
                                                <span
                                                class="inline-flex items-center bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">
                                                <span class="w-2 h-2 me-1 bg-red-500 rounded-full"></span>
                                                Inactive
                                                </span>
                                            `
                                       }
                                                </td>

                                                  <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                                  ${
                                                      item.initial_condition ||
                                                      ""
                                                  }
                                                </td>



                                                        <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                            ${item.item || ""}
                                    </td>
                                         <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                            ${item.specification || ""}
                                    </td>





                                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                                   ${item.holder_name || ""}
                                                </td>
                                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                                    ${item.department || ""}
                                                </td>
                                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                                    ${item.company || ""}

                                                </td>
                                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                                     ${item.old_code || ""}
                                                </td>

                                                                  <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                                      ${item.document || ""}
                                                </td>
                                                     <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                                        ${
                                                            item.status_recieved ||
                                                            ""
                                                        }
                                                        </td>
                                                     <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                               ${
                                                   item.created_at
                                                       ? new Date(
                                                             item.created_at
                                                         )
                                                             .toLocaleDateString(
                                                                 "en-GB",
                                                                 {
                                                                     day: "2-digit",
                                                                     month: "short",
                                                                     year: "numeric",
                                                                 }
                                                             )
                                                             .replace(/ /g, "-") // replace spaces with dashes
                                                       : ""
                                               }


                                                <td class=" bg-gray-100 dark:bg-black text-gray-900 whitespace-nowrap dark:text-white">
                                                <div class="option">
                                                    <button id="dropdownMenuIconHorizontalButton${
                                                        item.assets_id
                                                    }"
                                                        data-dropdown-toggle="dropdownDotsHorizontal${
                                                            item.assets_id
                                                        }"
                                                        class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                                                        type="button">
                                                   <i class="fa-solid fa-gear"></i>
                                                    </button>

                                                    <!-- Dropdown menu -->
                                                    <div id="dropdownDotsHorizontal${
                                                        item.assets_id
                                                    }"
                                                        class=" hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700 dark:divide-gray-600">

                                                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                                            aria-labelledby="dropdownMenuIconHorizontalButton${
                                                                item.assets_id
                                                            }">
                                                `;
                    if (
                        auth?.permission?.transfer_write == 1 &&
                        item.deleted != 1
                    ) {
                        custom += `

                                                                <li class="movement">
                                                                    <a href="/admin/movement/add/detail/id=${item.assets_id}"
                                                                       class="block px-4 py-2 hover:bg-gray-200  bg-white text-black dark:bg-black dark:text-white dark:hover:bg-white dark:hover:text-black">Movement</a>
                                                                </li>
                                                        `;
                    }

                    if (auth?.permission?.assets_read == 1) {
                        custom += `

                                                            <li>
                                                                    <a href="/admin/assets/data/view/id=${item.assets_id}/variant=${item.variant}"
                                                                        class="block px-4 py-2 hover:bg-gray-200  bg-white text-black dark:bg-black dark:text-white dark:hover:bg-white dark:hover:text-black">View</a>
                                                                </li>



                                                                <li>
                                                                    <a href="/admin/assets/data/update/id=${item.assets_id}/variant=${item.variant}"
                                                                        class="block px-4 py-2 hover:bg-gray-200  bg-white text-black dark:bg-black dark:text-white dark:hover:bg-white dark:hover:text-black">Update</a>
                                                                </li>


                                                    `;
                    }
                    if (
                        auth?.permission?.assets_delete == 1 &&
                        item.deleted != 1
                    ) {
                        custom += `


                                                       <li class="cursor block px-4 py-2 hover:bg-gray-200 bg-white text-black dark:bg-black dark:text-white dark:hover:bg-white dark:hover:text-black"
                                                        data-id="${item.assets_id}"
                                                        id="btn_delete_asset${item.assets_id}"
                                                        onclick="openDeleteModal('btn_delete_asset${item.assets_id}')">
                                                        Delete
                                                    </li>
                                                `;
                    }

                    custom += `
                                                    </ul>

                                                    </div>
                                                </div>
                                                `;

                    body_change.innerHTML += custom;
                });
                initFlowbite();
                // array = data.data;
            } else {
                toast_red.querySelector("p").innerHTML = "Data not Found.";
                pagination_search.innerHTML = `
                  <div class="flex main_page ">
                                <span class="font-bold flex justify-center items-center dark:text-slate-50">Data Not Found</span>
                                <ul class="flex items-center -space-x-px h-8 text-sm">
                                    <li class="mx-2" style="margin-left:10px;">
                                                <a href="0" aria-current="page"
                                                class="z-10 flex items-center justify-center px-1 h-4   lg:px-3 lg:h-8  md:px-1 md:h-4 leading-tight text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">
                                                <i class="fa-solid fa-filter-circle-xmark" style="color: #ff0000;">
                                                </i>
                                            </a>
                                        </li>
                                </ul>
                            </div>

                `;
                body_change.innerHTML = "";
                toast_red.style.display = "block";
                toast_red.style.animation = "none"; // reset animation
                toast_red.offsetHeight; // trigger reflow to restart animation
                toast_red.style.animation = "fadeOut2 4s forwards"; // start animation
            }
        } else {
            toast_red.querySelector("p").innerHTML = "Data not Found.";
            pagination_search.innerHTML = `
                  <div class="flex main_page ">
                                <span class="font-bold flex justify-center items-center dark:text-slate-50">Data Not Found</span>
                                <ul class="flex items-center -space-x-px h-8 text-sm">
                                    <li class="mx-2" style="margin-left:10px;">
                                                <a href="0" aria-current="page"
                                                class="z-10 flex items-center justify-center px-1 h-4   lg:px-3 lg:h-8  md:px-1 md:h-4 leading-tight text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">
                                                <i class="fa-solid fa-filter-circle-xmark" style="color: #ff0000;">
                                                </i>
                                            </a>
                                        </li>
                                </ul>
                            </div>

                `;
            body_change.innerHTML = "";
            toast_red.style.display = "block";
            toast_red.style.animation = "none"; // reset animation
            toast_red.offsetHeight; // trigger reflow to restart animation
            toast_red.style.animation = "fadeOut2 4s forwards"; // start animation
        }
    } else {
        toast_red.querySelector("p").innerHTML =
            "Problem on database connection.";
        pagination_search.innerHTML = ``;
        toast_red.style.display = "block";
        toast_red.style.animation = "none"; // reset animation
        toast_red.offsetHeight; // trigger reflow to restart animation
        toast_red.style.animation = "fadeOut2 4s forwards"; // start animation
    }
}
async function search_movement(no) {
    // Prevent multiple click
    id_for_export = [];
    let select_all_v = document.querySelector("#select_all");
    select_all_v.checked = false;
    print.style.display = "none";
    export_excel.style.display = "none";

    let asset_input = document.querySelector("#assets");
    let description = document.querySelector("#description");
    let start = document.querySelector("#start_date");
    let end = document.querySelector("#end_date");
    let state = document.querySelector("#state");
    let other = document.querySelector("#other_search");
    let value = document.querySelector("#other_value");
    let user = document.querySelector("#user");
    let company = document.querySelector("#company");
    let deleted = document.querySelector("#deleted");

    let user_val = "NA";
    let company_val = "NA";
    let department_val = selected_dep ?? "NA";
    let asset_val = "NA";
    let description_val = "NA";
    let start_val = "NA";
    let end_val = "NA";
    let state_val = "NA";
    let type_val = "NA";
    let value_val = "NA";
    let initial_condition = selected ?? "NA";
    let delete_val = "All";

    let page = 1;
    if (no) {
        page = no;
    }
    if (deleted) {
        delete_val = deleted.value;
    }
    if (user) {
        if (user.value != "") {
            user_val = user.value;
        }
    }
    if (company) {
        if (company.value != "") {
            company_val = company.value;
        }
    }
    if (asset_input) {
        if (asset_input.value != "") {
            asset_val = asset_input.value;
        }
    }
    if (description) {
        if (description.value != "") {
            description_val = description.value;
        }
    }
    if (start) {
        if (start.value != "") {
            start_val = start.value;
        }
    }
    if (end) {
        if (end.value != "") {
            end_val = end.value;
        }
    }
    if (state) {
        if (state.value != "") {
            state_val = state.value;
        }
    }

    if (start_val && end_val && start_val != "NA" && end_val != "NA") {
        if (start_val > end_val) {
            alert(
                "Start Date is greater than End Date.Please select correct date and Try again."
            );
            return;
        }
    }
    if (value) {
        if (value.value != "") {
            value_val = value.value;
        }
    }
    if (other) {
        type_val = other.value;
    }
    url = `/api/fect/movement/data`;

    let data;
    try {
        const url = `/api/fect/movement/data`;

        // Run loader while fetching
        data = await showLoader(async () => {
            const response = await fetch(url, {
                method: "POST",
                headers: {
                    Authorization: `Bearer ${token}`,
                    "Content-Type": "application/json",
                    "Cache-Control": "no-cache",
                    Pragma: "no-cache",
                },
                body: JSON.stringify({
                    type: type_val,
                    value: value_val,
                    user: user_val,
                    state: state_val,
                    asset: asset_val,
                    department: department_val,
                    company: company_val,
                    end: end_val,
                    start: start_val,
                    description: description_val,
                    initial_condition: initial_condition,
                    deleted: delete_val,
                    page: page,
                    _t: Date.now(),
                }),
            });

            return await response.json(); // return the fetched data
        });

        console.log(data); // JSON response is now available
    } catch (error) {
        alert(error);
    }

    let body_change = document.querySelector("#assets_body");
    let pagination_search = document.querySelector(".pagination_by_search");
    if (data) {
        if (data.data) {
            if (data.data.length > 0) {
                if (pagination_search) {
                    pagination_search.style.display = "block";

                    if (data.page != 0) {
                        let page = data.page;
                        let totalPage = data.total_page;
                        let totalRecord = data.total_record;

                        // Start by building the entire HTML content in one go
                        let paginationHtml = `

                                <ul class="flex items-center -space-x-px h-8 text-sm">

                                `;

                        // Add the current page dynamically
                        let left_val = page - 5;
                        if (left_val < 1) {
                            left_val = 1;
                        }
                        if (page != 1 && totalPage != 1) {
                            paginationHtml += `
                                    <li onclick="search_movement(${
                                        page - 1
                                    })"  class="flex items-center justify-center px-1 h-4   lg:px-3 lg:h-8  md:px-1 md:h-4 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">


                                            <i class="fa-solid fa-angle-left"></i>

                                    </li>
                                 `;
                        }
                        let right_val = page + 5;
                        if (right_val > totalPage) {
                            right_val = totalPage;
                        }

                        for (let i = left_val; i <= right_val; i++) {
                            if (i != page) {
                                paginationHtml += `
                                        <li onclick="search_movement(${i})" class="flex items-center justify-center px-1 h-4   lg:px-3 lg:h-8  md:px-1 md:h-4 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                                        >

                                                 ${i}


                                         </li>
                                     `;
                            } else if (i == page) {
                                paginationHtml += `
                                          <li onclick="search_movement(${i})" class="z-10 flex items-center justify-center px-1 h-4   lg:px-3 lg:h-8  md:px-1 md:h-4 leading-tight text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">

                                                ${i}

                                        </li>
                                     `;
                            }
                        }

                        if (page != totalPage) {
                            paginationHtml += `
                                    <li  onclick="search_movement(${
                                        page + 1
                                    })"  class="flex items-center justify-center px-1 h-4   lg:px-3 lg:h-8  md:px-1 md:h-4 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">


                                            <i class="fa-solid fa-chevron-right"></i>

                                    </li>
                    `;
                        }

                        paginationHtml += `
                           <li class="mx-2" style="margin-left:10px;">
                                    <a href="${page_view}" aria-current="page"
                                        class="z-10 flex items-center justify-center px-1 h-4   lg:px-3 lg:h-8  md:px-1 md:h-4 leading-tight text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">
                                        <i class="fa-solid fa-filter-circle-xmark" style="color: #ff0000;"></i>
                                    </a>
                                </li>
                                </ul>
                        <select
                            onchange="set_page_dynamic_admin_movement()"
                            id="select_page_dynamic_movement"
                             class="flex  items-center justify-center px-1 h-8   lg:px-3 lg:h-8  md:px-1 md:h-8 text-sm leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                             `;
                        if (page != 1) {
                            paginationHtml += `
                                 <option value="${page}">${page}</option>
                                 `;
                        }

                        for (let i = 1; i <= totalPage; i++) {
                            paginationHtml += `
                                 <option value="${i}">${i}</option>
                                 `;
                        }

                        paginationHtml += `
                                 </select>


                                    <span class="font-bold flex justify-center items-center dark:text-slate-50">Found Page :${totalPage} Pages
                                        &ensp;Total Transaction: ${totalRecord} Records</span>


                                 </div>
                                 `;

                        // Finally, assign the full HTML to the element
                        pagination_search.innerHTML = paginationHtml;
                    }
                }

                body_change.innerHTML = ``;

                data.data.map((item, index) => {
                    let custom = ``;
                    if (item.deleted == 1) {
                        custom += `
                             <tr   tabindex="0" class=" deleted_record bg-rose-100 border-b dark:bg-rose-800 dark:border-gray-700">
                                <td class="print_val ">
                                    <input onchange="printable()" data-id="{{ $item->assets_id }}"
                                        id="green-checkbox{{ $item->id }}" type="checkbox" value=""
                                        class="select_box w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <span class="px-2 ">Deleted</span>
                                              </td>
                        `;
                    } else {
                        custom += `
                           <tr   tabindex="0" class="bg-white text-black  border-b dark:bg-gray-800 dark:text-white dark:border-gray-700">
                            <!-- Checkbox -->
                            <td class="print_val px-2 py-1 lg:px-6 lg:py-4 md:px-4 md:py-2">
                                <input onchange="printable()" data-id="${
                                    item.assets_id || ""
                                }"
                                    id="green-checkbox${
                                        item.id
                                    }" type="checkbox" value=""
                                    class="select_box w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded
                                    focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800
                                    focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                          </td>
                        `;
                    }
                    custom += `

        <!-- Asset ID -->
        <td class="px-2 py-1 lg:px-6 lg:py-4 md:px-4 md:py-2">
            ${item.assets_id || ""}
        </td>

        <!-- Transaction Date -->
        <td class="px-2 py-1 lg:px-6 lg:py-4 md:px-4 md:py-2">
            ${
                item.transaction_date
                    ? new Date(item.transaction_date)
                          .toLocaleDateString("en-GB", {
                              day: "2-digit",
                              month: "short",
                              year: "numeric",
                          })
                          .replace(/ /g, "-") // replace spaces with dashes
                    : ""
            }
        </td>

        <!-- Assets Code -->
        <td class="px-2 py-1 lg:px-6 lg:py-4 md:px-4 md:py-2">
            ${(item.assets1 || "") + (item.assets2 || "")}
        </td>

        <!-- Status -->
        <td class="px-2 py-1 lg:px-6 lg:py-4 md:px-4 md:py-2">
            ${
                item.status == 0
                    ? `
                        <span class="inline-flex items-center bg-red-100 text-red-800 text-xs font-medium
                        px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">
                            <span class="w-2 h-2 me-1 bg-red-500 rounded-full"></span>Inactive
                        </span>`
                    : `
                        <span class="inline-flex items-center bg-green-100 text-green-800 text-xs font-medium
                        px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
                            <span class="w-2 h-2 me-1 bg-green-500 rounded-full"></span>Active
                        </span>`
            }
        </td>
                <!-- Initial Condition -->
        <td class="px-2 py-1 lg:px-6 lg:py-4 md:px-4 md:py-2">${
            item.initial_condition || ""
        }</td>


        <!-- Item -->
        <td class="px-2 py-1 lg:px-6 lg:py-4 md:px-4 md:py-2">${
            item.item || ""
        }</td>

        <!-- Specification -->
        <td class="px-2 py-1 lg:px-6 lg:py-4 md:px-4 md:py-2">${
            item.specification || ""
        }</td>



        <!-- Holder -->
        <td class="px-2 py-1 lg:px-6 lg:py-4 md:px-4 md:py-2">${
            item.holder_name || ""
        }</td>

        <!-- Department -->
        <td class="px-2 py-1 lg:px-6 lg:py-4 md:px-4 md:py-2">${
            item.department || ""
        }</td>

        <!-- Company -->
        <td class="px-2 py-1 lg:px-6 lg:py-4 md:px-4 md:py-2">${
            item.company || ""
        }</td>

        <!-- Old Code -->
        <td class="px-2 py-1 lg:px-6 lg:py-4 md:px-4 md:py-2">${
            item.old_code || ""
        }</td>

        <!-- Reference -->
        <td class="px-2 py-1 lg:px-6 lg:py-4 md:px-4 md:py-2">${
            item.reference || ""
        }</td>
         <td class="px-2 py-1 lg:px-6 lg:py-4 md:px-4 md:py-2">${
             item.purpose || ""
         }</td>
          <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                                        ${
                                                            item.status_recieved ||
                                                            ""
                                                        }
                                                        </td>
        <!-- Created Date -->
        <td class="px-2 py-1 lg:px-6 lg:py-4 md:px-4 md:py-2">
            ${
                item.created_at
                    ? new Date(item.created_at)
                          .toLocaleDateString("en-GB", {
                              day: "2-digit",
                              month: "short",
                              year: "numeric",
                          })
                          .replace(/ /g, "-") // replace spaces with dashes
                    : ""
            }
        </td>
        <!-- Actions -->
        <td class="bg-gray-100 dark:bg-black text-gray-900 whitespace-nowrap dark:text-white">`;
                    if (item.status == 1) {
                        custom += `
                                    <div class="option">
                                        <button id="dropdownMenuIconHorizontalButton${item.assets_id}"
                                            data-dropdown-toggle="dropdownDotsHorizontal${item.assets_id}"
                                            class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-900
                                            bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none
                                            dark:text-white focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700
                                            dark:focus:ring-gray-600"
                                            type="button">
                                               <i class="fa-solid fa-gear"></i>
                                        </button>

                                        <div id="dropdownDotsHorizontal${item.assets_id}"
                                            class="hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44
                                            dark:bg-gray-700 dark:divide-gray-600">
                                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                                aria-labelledby="dropdownMenuIconHorizontalButton${item.assets_id}">`;

                        // Movement
                        if (
                            auth?.permission?.transfer_write == 1 &&
                            item.deleted == 0
                        ) {
                            custom += `
                                                <li class="movement">
                                                    <a href="/admin/movement/add/detail/id=${item.assets_id}"
                                                       class="block px-4 py-2 hover:bg-gray-200  bg-white text-black dark:bg-black dark:text-white dark:hover:bg-white dark:hover:text-black">
                                                        Movement
                                                    </a>
                                                </li>`;
                        }

                        // View / Update

                        custom += `
                                <li>
                                    <a href="/admin/assets/data/view/id=${item.assets_id}/variant=${item.variant}"
                                        class="block px-4 py-2 hover:bg-gray-200  bg-white text-black dark:bg-black dark:text-white dark:hover:bg-white dark:hover:text-black">
                                        View
                                    </a>
                                </li>
                            `;

                        if (auth?.permission?.assets_update == 1) {
                            custom += `
                            <li>
                                <a href="/admin/assets/data/update/id=${item.assets_id}/variant=${item.variant}"
                                    class="block px-4 py-2 hover:bg-gray-200  bg-white text-black dark:bg-black dark:text-white dark:hover:bg-white dark:hover:text-black">
                                    Update
                                </a>
                            </li>
                            `;
                        }

                        // Delete
                        if (
                            auth?.permission?.assets_delete == 1 &&
                            item.deleted == 0
                        ) {
                            custom += `

                                                     <li class="cursor block px-4 py-2 hover:bg-gray-200 bg-white text-black dark:bg-black dark:text-white dark:hover:bg-white dark:hover:text-black"
                                                        data-id="${item.assets_id}"
                                                        id="btn_delete_asset${item.assets_id}"
                                                        onclick="openDeleteModal('btn_delete_asset${item.assets_id}')">
                                                        Delete
                                                    </li>

                                                `;
                        }

                        custom += `
                                                                            </ul>
                                                                        </div>
                                                                    </div>`;
                    } else {
                        custom += `
                         <a
                                            href="/admin/assets/data/view/id=${item.assets_id}/variant=${item.variant}">
                                            <button data-popover-target="popover-default${index}"
                                                type="button"
                                                class="text-black mx-2 bg-grey-100 hover:bg-grey-200 focus:ring-4 focus:outline-none focus:ring-blue-100 font-medium rounded-lg text-sm px-2.5 py-2 text-center dark:bg-gray-900 dark:hover:bg-gray-200 dark:focus:ring-gray-300 dark:text-white">

                                                <i class="fa-solid fa-eye "></i>
                                            </button>
                                        </a>
                        `;
                    }

                    custom += `</td>
                            </tr>`;
                    body_change.innerHTML += custom;
                });

                initFlowbite();
                // array = data.data;
            } else {
                toast_red.querySelector("p").innerHTML = "Data not Found.";
                pagination_search.innerHTML = `
                            <div class="flex main_page ">
                                <span class="font-bold flex justify-center items-center dark:text-slate-50">Data Not Found</span>
                                <ul class="flex items-center -space-x-px h-8 text-sm">
                                    <li class="mx-2" style="margin-left:10px;">
                                                <a href="0" aria-current="page"
                                                class="z-10 flex items-center justify-center px-1 h-4   lg:px-3 lg:h-8  md:px-1 md:h-4 leading-tight text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">
                                                <i class="fa-solid fa-filter-circle-xmark" style="color: #ff0000;">
                                                </i>
                                            </a>
                                        </li>
                                </ul>
                            </div>
                                `;
                toast_red.style.display = "block";
                toast_red.style.animation = "none"; // reset animation
                body_change.innerHTML = "";
                toast_red.offsetHeight; // trigger reflow to restart animation
                toast_red.style.animation = "fadeOut2 4s forwards"; // start animation
            }
        } else {
            toast_red.querySelector("p").innerHTML = "Data not Found.";
            pagination_search.innerHTML = `
                            <div class="flex main_page ">
                                <span class="font-bold flex justify-center items-center dark:text-slate-50">Data Not Found</span>
                                <ul class="flex items-center -space-x-px h-8 text-sm">
                                    <li class="mx-2" style="margin-left:10px;">
                                                <a href="0" aria-current="page"
                                                class="z-10 flex items-center justify-center px-1 h-4   lg:px-3 lg:h-8  md:px-1 md:h-4 leading-tight text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">
                                                <i class="fa-solid fa-filter-circle-xmark" style="color: #ff0000;">
                                                </i>
                                            </a>
                                        </li>
                                </ul>
                            </div>
                                `;
            toast_red.style.display = "block";
            toast_red.style.animation = "none"; // reset animation
            body_change.innerHTML = "";
            toast_red.offsetHeight; // trigger reflow to restart animation
            toast_red.style.animation = "fadeOut2 4s forwards"; // start animation
        }
    } else {
        toast_red.querySelector("p").innerHTML =
            "Problem on database connection.";
        toast_red.style.display = "block";
        toast_red.style.animation = "none"; // reset animation
        toast_red.offsetHeight; // trigger reflow to restart animation
        toast_red.style.animation = "fadeOut2 4s forwards"; // start animation
    }
}

function set_page_dynamic() {
    let select = document.querySelector("#select_page_dynamic");

    if (select) {
        if (select.value != "") {
            search_asset(parseInt(select.value));
        }
    }
}
-function set_page_movement() {
    let select = document.querySelector("#select_page_dynamic");
    if (select) {
        if (select.value != "") {
            search_movement(parseInt(select.value));
        }
    }
};

function set_page_dynamic_admin() {
    let select = document.querySelector("#select_page_dynamic");
    if (select) {
        if (select.value != "") {
            search_asset(parseInt(select.value));
        }
    }
}
function set_page_dynamic_admin_movement() {
    let select = document.querySelector("#select_page_dynamic");
    if (select) {
        if (select.value != "") {
            search_movement(parseInt(select.value));
        }
    }
}

function select_page_dynamic_select_movement() {
    let select = document.querySelector("#select_page_dynamic");
    if (select) {
        if (select.value != "") {
            search_asset_for_movement(parseInt(select.value));
        }
    }
}
function set_page_dynamic_changelog() {
    let select = document.querySelector("#select_page_dynamic_changelog");
    if (select) {
        if (select.value != "") {
            search_change_log(parseInt(select.value));
        }
    }
}
function set_page_dynamic_raw() {
    let select = document.querySelector("#select_page_dynamic_raw");
    if (select) {
        if (select.value != "") {
            raw_assets(parseInt(select.value));
        }
    }
}

function set_page_dynamic_quick() {
    let select = document.querySelector("#select_page_dynamic_quick");
    if (select) {
        if (select.value != "") {
            search_quick_data(parseInt(select.value));
        }
    }
}
function set_page_dynamic_admin_movement() {
    let select = document.querySelector("#select_page_dynamic_movement");
    if (select) {
        if (select.value != "") {
            search_movement(parseInt(select.value));
        }
    }
}

function check_date() {
    // initailize
    let start_input = "NA";
    let end_input = "NA";

    let input_start = document.querySelector("#start_date");
    let input_end = document.querySelector("#end_date");

    if (input_start) {
        if (input_start != "") {
            start_input = new Date(input_start.value);
        }
    }
    if (input_end) {
        if (input_end != "") {
            end_input = new Date(input_end.value);
        }
    }
    if (start_input != "NA" && end_input != "NA") {
        if (start_input > end_input) {
            alert(
                "Start Date is greater than End Date.Please select correct date and Try again."
            );
            // Get today's date in the format 'YYYY-MM-DD'
            let today = new Date().toISOString().split("T")[0];

            input_start.value = today;
            return;
        }
    }
}

async function raw_assets(no) {
    let Assets = document.querySelector("#assets");
    let Fa = document.querySelector("#fa");
    let Invoice = document.querySelector("#invoice");
    let Description = document.querySelector("#description");
    let StartDate = document.querySelector("#start_date");
    let EndDate = document.querySelector("#end_date");
    let State = document.querySelector("#state");

    let fa_value = "NA";
    let invoice_value = "NA";
    let startDateValue = "NA";
    let endDateValue = "NA";
    let description_value = "NA";
    let assets_value = "NA";
    let state_value = "NA";
    let page = 1;
    if (no) {
        page = no;
    }

    if (Fa) {
        if (Fa.value != "") {
            fa_value = Fa.value;
        }
    }

    if (StartDate) {
        if (StartDate.value != "") {
            startDateValue = new Date(StartDate.value);
        }
    }
    if (EndDate) {
        if (EndDate.value != "") {
            endDateValue = new Date(EndDate.value);
        }
    }

    if (Invoice) {
        if (Invoice.value != "") {
            invoice_value = Invoice.value;
        }
    }

    if (Description) {
        if (Description.value != "") {
            description_value = Description.value;
        }
    }
    if (Assets) {
        if (Assets.value != "") {
            assets_value = Assets.value;
        }
    }
    if (State) {
        if (State.value != "") {
            state_value = State.value;
        }
    }
    // Loading label
    let url = `/api/raw/assets`;
    let data;
    try {
        // Run loader while fetching

        data = await showLoader(async () => {
            const response = await fetch(url, {
                method: "POST",
                headers: {
                    Authorization: `Bearer ${token}`,
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    asset_val: assets_value,
                    fa_val: fa_value,
                    invoice_val: invoice_value,
                    description_val: description_value,
                    start_val: startDateValue,
                    end_val: endDateValue,
                    state_val: state_value,
                    page: page,
                }),
            });

            return await response.json(); // return the fetched data
        });
    } catch (error) {
        alert(error);
    }

    let body_table = document.querySelector("#table_raw_body");
    console.log(data);
    if (data) {
        if (data.data) {
            if (data.data.length > 0) {
                let defualt = document.querySelector(".defualt");
                if (defualt) {
                    defualt.style.display = "none";
                }

                let pagination_search = document.querySelector(
                    ".pagination_by_search"
                );

                if (pagination_search) {
                    pagination_search.style.display = "block";

                    if (data.page != 0) {
                        let page = data.page;
                        let totalPage = data.total_page;
                        let totalRecord = data.total_record ?? 0;
                        // Start by building the entire HTML content in one go
                        let paginationHtml = `
                        <div class="flex main_page ">
                            <ul class="flex items-center -space-x-px h-8 text-sm">

                            `;

                        // Add the current page dynamically
                        let left_val = page - 5;
                        if (left_val < 1) {
                            left_val = 1;
                        }
                        if (page != 1 && totalPage != 1) {
                            paginationHtml += `
                                <li onclick="raw_assets(${
                                    page - 1
                                })"  class="flex items-center justify-center px-1 h-4   lg:px-3 lg:h-8  md:px-1 md:h-4 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">


                                        <i class="fa-solid fa-angle-left"></i>

                                </li>
                             `;
                        }
                        let right_val = page + 5;
                        if (right_val > totalPage) {
                            right_val = totalPage;
                        }
                        var state_i = 0;
                        for (let i = left_val; i <= right_val; i++) {
                            if (i != page) {
                                paginationHtml += `
                                    <li onclick="raw_assets(${i})" class="flex items-center justify-center px-1 h-4   lg:px-3 lg:h-8  md:px-1 md:h-4 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                                    >

                                             ${i}


                                     </li>
                                 `;
                                state_i = i;
                            } else if (i == page) {
                                paginationHtml += `
                                      <li onclick="raw_assets(${i})" class="z-10 flex items-center justify-center px-1 h-4   lg:px-3 lg:h-8  md:px-1 md:h-4 leading-tight text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">

                                            ${i}

                                    </li>
                                 `;
                                state_i = i;
                            }
                        }
                        if (state_i != totalPage) {
                            paginationHtml += `
                         <li onclick="raw_assets(${totalPage})" class="flex items-center justify-center px-1 h-4   lg:px-3 lg:h-8  md:px-1 md:h-4 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                    >

                            ${totalPage}


                 </li>`;
                        }

                        if (page != totalPage) {
                            paginationHtml += `

                                <li>
                                    <a href=""
                                        class="flex items-center justify-center px-1 h-4   lg:px-3 lg:h-8  md:px-1 md:h-4 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                        <i class="fa-solid fa-chevron-right"></i>
                                    </a>
                                </li>
                                    `;
                        }

                        // Add the remaining pagination buttons and close the list
                        paginationHtml += `


                            <li class="mx-2" style="margin-left:10px;">
                                <a href="1" aria-current="page"
                                    class="z-10 flex items-center justify-center px-1 h-4   lg:px-3 lg:h-8  md:px-1 md:h-4 leading-tight text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">
                                    <i class="fa-solid fa-filter-circle-xmark" style="color: #ff0000;"></i>
                                </a>
                            </li>
                            </ul>


                            `;

                        paginationHtml += `
                            <select  onchange="set_page_dynamic_raw()" id="select_page_dynamic_raw"  class="flex mx-2 items-center justify-center px-1 h-8   lg:px-3 lg:h-8  md:px-1 md:h-4 text-sm leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"  name="" id="">
                            <option value="${page}">${page}</option>
                            `;

                        for (i = 1; i <= totalPage; i++) {
                            paginationHtml += `<option value="${i}">${i}</option>`;
                        }

                        paginationHtml += `
                            </select>
                         `;

                        paginationHtml += `
                        <span class="font-bold flex justify-center items-center">Page :${totalPage} Pages  &ensp;Total Assets: ${totalRecord} Records</span>

                        </div>
                        `;

                        totalRecord;
                        // Finally, assign the full HTML to the element
                        pagination_search.innerHTML = paginationHtml;
                    }
                }
                body_table.innerHTML = `
            ${data.data
                .map((item, index) => {
                    return `
            <tr   tabindex="0" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"">
                <td scope="row"
                class="px-2 py-1 lg:px-6 lg:py-4 md:px-4 md:py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                ${index + 1}
            </td>
            <td scope="row"
                class="px-2 py-1 lg:px-6 lg:py-4 md:px-4 md:py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                ${
                    item.posting_date
                        ? new Date(item.posting_date).toLocaleDateString(
                              "en-US",
                              {
                                  year: "numeric",
                                  month: "short",
                                  day: "numeric",
                              }
                          )
                        : ""
                }
            </td>
            <td scope="row"
                class="px-2 py-1 lg:px-6 lg:py-4 md:px-4 md:py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                ${item.assets??''}
            </td>
            <td scope="row"
                class="px-2 py-1 lg:px-6 lg:py-4 md:px-4 md:py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                ${item.fa??''}
            </td>
            <td scope="row"
                class="px-2 py-1 lg:px-6 lg:py-4 md:px-4 md:py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                ${item.invoice_no??''}
            </td>
            <td scope="row"
                class="px-2 py-1 lg:px-6 lg:py-4 md:px-4 md:py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                ${item.Description??''}
            </td>
            <td>
                ${
                    item.is_registered == 1
                        ? `
                          <span
                                        class="inline-flex items-center  text-green-800 text-xs font-medium px-2.5 py-2 rounded-full dark:bg-green-900 dark:text-green-300">
                                       <i class="fa-solid fa-circle-check mx-2" style="color: #369900;"></i>
                                       Registerd
                                    </span>


                        `
                        : `<a href="/admin/assets/add/assets=${
                              item.assets
                          }/invoice_no=${
                              item.fa ? item.fa.replace(/\//g, "-") : "NA"
                          }">
                               <button data-popover-target="popover-default${index}" type="button"
                                   class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-2.5 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                   <i class="fa-solid fa-square-plus" style="font-size:25px"></i>
                               </button>
                          </a>
                          <div data-popover id="popover-default${index}" role="tooltip"
                               class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-xs opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                               <div class="px-3 py-2 bg-gray-100 border-b border-gray-200 rounded-t-lg dark:border-gray-600 dark:bg-gray-700">
                                   <h3 class="font-semibold text-gray-900 dark:text-white">Info</h3>
                               </div>
                               <div class="px-3 py-2">
                                   <p>Select This Invoice to Create New Assets</p>
                               </div>
                               <div data-popper-arrow></div>
                          </div>`
                }
            </td>
        </tr>`;
                })
                .join("")}
        `;
                array = data.data;
            }
        } else {
            alert("No Data Found.");
        }
    } else {
        alert("No Data Found.");
    }
    // Loading label
    document.querySelector("#loading").style.display = "none";
}
function filter_by_page(no) {
    search_change_log(no);
}

async function search_change_log(no) {
    let key = document.querySelector("#key");
    let varaint = document.querySelector("#varaint");
    let change = document.querySelector("#change");
    let section = document.querySelector("#section");
    let change_by = document.querySelector("#chang_by");
    let start_change = document.querySelector("#start_date");
    let end_change = document.querySelector("#end_date");

    let key_val = "NA";
    let varaint_val = "NA";
    let change_val = "NA";
    let section_val = "NA";
    let change_by_val = "NA";
    let start_val = "NA";
    let end_val = "NA";

    if (key) {
        if (key.value != "") {
            key_val = key.value;
        }
    }
    if (varaint) {
        if (varaint.value != "") {
            varaint_val = varaint.value;
        }
    }
    if (change) {
        if (change.value != "") {
            change_val = change.value;
        }
    }
    if (section) {
        if (section.value != "") {
            section_val = section.value;
        }
    }
    if (change_by) {
        if (change_by.value != "") {
            change_by_val = change_by.value;
        }
    }
    if (start_change) {
        if (start_change.value != "") {
            start_val = start_change.value;
        }
    }
    if (end_change) {
        if (end_change.value != "") {
            end_val = end_change.value;
        }
    }

    let page = 1;
    if (no != 0) {
        page = no;
    }

    // Loading label
    document.querySelector("#loading").style.display = "block";

    let url = `/api/change/log`;
    let data = await fetch(url, {
        method: "POST",
        headers: {
            Authorization: `Bearer ${token}`,
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            key: key_val,
            varaint: varaint_val,
            change: change_val,
            section: section_val,
            change_by: change_by_val,
            start: start_val,
            end: end_val,
            page: page,
        }),
    })
        .then((response) => {
            if (!response.ok) {
                throw new Error("Network response was not ok");
            }
            return response.json(); // Expecting JSON
        })
        .then((data) => {
            return data; // Handle your data
        })
        .catch((error) => {
            alert(error);
        });

    if (data) {
        if (data.data) {
            document.querySelector("#loading").style.display = "none";
            if (data.data.length > 0) {
                let defualt = document.querySelector(".defualt");
                if (defualt) {
                    defualt.style.display = "none";
                }

                let pagination_search = document.querySelector(
                    ".pagination_by_search"
                );

                if (pagination_search) {
                    pagination_search.style.display = "block";

                    if (data.page != 0) {
                        let page = data.page;
                        let totalPage = data.total_page;
                        let totalRecord = data.total_record ?? 0;
                        // Start by building the entire HTML content in one go
                        let paginationHtml = `
                            <div class="flex  main_page ">
                                <ul class="flex items-center -space-x-px h-8 text-sm">

                                `;

                        // Add the current page dynamically
                        let left_val = page - 5;
                        if (left_val < 1) {
                            left_val = 1;
                        }
                        if (page != 1 && totalPage != 1) {
                            paginationHtml += `
                                    <li onclick="search_change_log(${
                                        page - 1
                                    })"  class="flex items-center justify-center px-1 h-4   lg:px-3 lg:h-8  md:px-1 md:h-4 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">


                                            <i class="fa-solid fa-angle-left"></i>

                                    </li>
                                 `;
                        }
                        let right_val = page + 5;
                        if (right_val > totalPage) {
                            right_val = totalPage;
                        }

                        for (let i = left_val; i <= right_val; i++) {
                            if (i != page) {
                                paginationHtml += `
                                        <li onclick="search_change_log(${i})" class="flex items-center justify-center px-1 h-4   lg:px-3 lg:h-8  md:px-1 md:h-4 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                                        >

                                                 ${i}


                                         </li>
                                     `;
                            } else if (i == page) {
                                paginationHtml += `
                                          <li onclick="search_change_log(${i})" class="z-10 flex items-center justify-center px-1 h-4   lg:px-3 lg:h-8  md:px-1 md:h-4 leading-tight text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">

                                                ${i}

                                        </li>
                                     `;
                            }
                        }

                        if (page != totalPage) {
                            paginationHtml += `
                                    <li>
                                        <a href=""
                                            class="flex items-center justify-center px-1 h-4   lg:px-3 lg:h-8  md:px-1 md:h-4 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                            <i class="fa-solid fa-chevron-right"></i>
                                        </a>
                                    </li>
                                        `;
                        }

                        // Add the remaining pagination buttons and close the list
                        paginationHtml += `


                                <li class="mx-2" style="margin-left:10px;">
                                    <a href="1" aria-current="page"
                                        class="z-10 flex items-center justify-center px-1 h-4   lg:px-3 lg:h-8  md:px-1 md:h-4 leading-tight text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">
                                        <i class="fa-solid fa-filter-circle-xmark" style="color: #ff0000;"></i>
                                    </a>
                                </li>
                                </ul>


                                `;

                        paginationHtml += `
                                <select  onchange="set_page_dynamic_changelog()" id="select_page_dynamic_changelog"  class="flex mx-0 lg:mx-2 items-center justify-center px-1 h-8   lg:px-3 lg:h-8  md:px-1 md:h-4 text-sm leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"  name="" id="">
                                <option value="${page}">${page}</option>
                                `;

                        for (i = 1; i <= totalPage; i++) {
                            paginationHtml += `<option value="${i}">${i}</option>`;
                        }

                        paginationHtml += `
                                </select>
                             `;

                        paginationHtml += `
                            <span class="font-bold flex justify-left items-center text-gray-900 dark:text-white">Page :${totalPage} Pages  &ensp;Total Changes: ${totalRecord} Records</span>

                            </div>
                            `;

                        totalRecord;
                        // Finally, assign the full HTML to the element
                        pagination_search.innerHTML = paginationHtml;
                    }
                }

                let body_change = document.querySelector("#table_body_change");
                body_change.innerHTML = ``;
                data.data.map((item) => {
                    body_change.innerHTML += `

            <tr   tabindex="0" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                               <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                   ${item.id || ""}
                               </td>
                               <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                    ${item.key || ""}
                               </td>
                               <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                  ${item.varaint || ""}
                               </td>
                               <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                  ${item.change || ""}
                               </td>
                               <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                  ${item.section || ""}
                               </td>
                               <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                  ${item.change_by || ""}
                               </td>

                               <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                  ${
                                      item.created_at
                                          ? new Date(
                                                item.created_at
                                            ).toLocaleDateString("en-US", {
                                                year: "numeric",
                                                month: "short",
                                                day: "numeric",
                                            })
                                          : ""
                                  }

                               </td>


                           </tr>
          `;
                });
                array = data.data;
            } else {
                alert("Data not found");
                body_change.innerHTML = ``;
                document.querySelector("#loading").style.display = "none";
            }
        } else {
            alert("Data not found");
            body_change.innerHTML = ``;
            document.querySelector("#loading").style.display = "none";
        }
    } else {
        alert("Error Fetch not responce");
        body_change.innerHTML = ``;
        document.querySelector("#loading").style.display = "none";
    }
}
function set_page() {
    let select_page = document.querySelector("#select_page");

    if (select_page) {
        if (select_page.value != "") {
            window.location.href = `/admin/assets/transaction/${select_page.value}`;
        }
    }
}

function set_page_changeLog() {
    let select_page = document.querySelector("#select_page");

    if (select_page) {
        if (select_page.value != "") {
            window.location.href = `/admin/assets/change/log/${select_page.value}`;
        }
    }
}

function set_page_raw() {
    let select_page = document.querySelector("#select_page");

    if (select_page) {
        if (select_page.value != "") {
            window.location.href = `/admin/assets/add/${select_page.value}`;
        }
    }
}

// Search Data Asset using Fetch
async function search_mobile(asset) {
    let input_assets = document.querySelector("#sidebar-search");
    let panel_list = document.querySelector("#show_list");

    let val = "NA";
    if (input_assets) {
        if (input_assets.value != "") {
            val = input_assets.value;
        }
    }

    let url = `/api/search/mobile`;
    let data = await fetch(url, {
        method: "POST",
        headers: {
            Authorization: `Bearer ${token}`,
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            assets: val,
            role: auth.role,
        }),
    })
        .then((response) => {
            if (!response.ok) {
                throw new Error("Network response was not ok");
            }
            return response.json(); // Expecting JSON
        })
        .then((data) => {
            return data; // Handle your data
        })
        .catch((error) => {
            alert(error);
        });

    if (data) {
        if (data.data) {
            if (data.data.length != 0) {
                panel_list.innerHTML = ``;
                let custom = `
                <button onclick="close_search()">Close</button>
                      <table id="list_assets"
                            class="table_respond max-w-full  text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                              <tr   tabindex="0">
                                 <th scope="col" class="px-6 py-3">
                                    Action
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                    Assets Code
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                    Invoice
                                    </th>
                                     <th scope="col" class="px-6 py-3">
                                    Description
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="assets_body">
                            `;

                data.data.map((item, index) => {
                    custom += `
                        <tr   tabindex="0" class=" bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <td >
                                                <a href="/admin/assets/edit/id=${
                                                    item.id
                                                }"> <button>View</button></a>

                                             </td>
                                             <td >
                                                ${item.assets1 + item.assets2}
                                             </td>
                                             <td >
                                                ${item.invoice_no}
                                             </td>
                                                    <td >
                                                ${item.description}
                                             </td>
                         </tr>`;
                });

                custom += `
                            </tbody>
                        </table>
                    `;
                panel_list.innerHTML = custom;
                panel_list.style.display = "block";
            } else {
                panel_list.innerHTML = ``;
                panel_list.innerHTML = `<h1>No Data Found.</h1>`;
                panel_list.style.display = "block";
            }
        } else {
            panel_list.innerHTML = ``;
            panel_list.innerHTML = `
                     <button onclick="close_search()">Close</button>
            <h1>No Data Found.</h1>`;
            panel_list.style.display = "block";
        }
    } else {
        panel_list.innerHTML = ``;
        panel_list.innerHTML = `<h1>Problem Data rendering</h1>`;
        panel_list.style.display = "block";
    }
}
function close_search() {
    let panel_list = document.querySelector("#show_list");
    panel_list.style.display = "none";
}

async function search_asset_new(no) {
    // Prevent multiple click
    id_for_export = [];
    let select_all_v = document.querySelector("#select_all");
    select_all_v.checked = false;
    print.style.display = "none";
    export_excel.style.display = "none";

    let department = document.querySelector("#department");
    let user = document.querySelector("#user");
    let company = document.querySelector("#company");

    const asset_input = document.querySelector("#assets");
    const description = document.querySelector("#description");
    const start = document.querySelector("#start_date");
    const end = document.querySelector("#end_date");
    const state = document.querySelector("#state");
    const other = document.querySelector("#other_search");
    const value = document.querySelector("#other_value");

    let user_val = user?.value || "NA";
    let company_val = company?.value || "NA";
    let asset_val = asset_input?.value || "NA";
    let department_val = department?.value || "NA";
    let description_val = description?.value || "NA";
    let start_val = start?.value || "NA";
    let end_val = end?.value || "NA";
    let state_val = state?.value || "NA";
    let type_val = other?.value || "NA";
    let value_val = value?.value || "NA";
    let page = no || 1;

    const url = `/api/fect/assets/new/data`;
    let data;
    try {
        // Run loader while fetching
        data = await showLoader(async () => {
            const response = await fetch(url, {
                method: "POST",
                headers: {
                    Authorization: `Bearer ${token}`,
                    "Content-Type": "application/json",
                    "Cache-Control": "no-cache",
                    Pragma: "no-cache",
                },
                body: JSON.stringify({
                    type: type_val,
                    value: value_val,
                    user: user_val,
                    state: state_val,
                    asset: asset_val,
                    company: company_val,
                    department: department_val,
                    end: end_val,
                    start: start_val,
                    description: description_val,
                    page: page,
                    _t: Date.now(), // 👈 cache buster
                }),
            });

            return await response.json(); // return the fetched data
        });

        console.log(data); // JSON response is now available
    } catch (error) {
        alert(error);
    }
    let pagination_search = document.querySelector(".pagination_by_search");
    let body_change = document.querySelector("#assets_body");
    if (data) {
        if (data.data && data.data.length > 0) {
            if (pagination_search) {
                pagination_search.style.display = "block";
                if (data.page != 0) {
                    const page = data.page;
                    const totalPage = data.total_page;
                    const totalRecord = data.total_record;
                    let paginationHtml = `<ul class="flex items-center -space-x-px h-8 text-sm">`;
                    let left_val = page - 5;
                    let page_view = page;
                    if (left_val < 1) left_val = 1;
                    if (page != 1 && totalPage != 1) {
                        paginationHtml += `
                            <li onclick="search_asset_new(${
                                page - 1
                            })" class="flex items-center justify-center px-1 h-4 lg:px-3 lg:h-8 md:px-1 md:h-4 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <i class="fa-solid fa-angle-left"></i>
                            </li>`;
                    }
                    let right_val = page + 5;
                    if (right_val > totalPage) right_val = totalPage;
                    for (let i = left_val; i <= right_val; i++) {
                        if (i != page) {
                            paginationHtml += `<li onclick="search_asset_new(${i})" class="flex items-center justify-center px-1 h-4 lg:px-3 lg:h-8 md:px-1 md:h-4 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">${i}</li>`;
                        } else {
                            paginationHtml += `<li onclick="search_asset_new(${i})" class="z-10 flex items-center justify-center px-1 h-4 lg:px-3 lg:h-8 md:px-1 md:h-4 leading-tight text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">${i}</li>`;
                        }
                    }
                    if (page != totalPage) {
                        paginationHtml += `<li onclick="search_asset_new(${
                            page + 1
                        })" class="flex items-center justify-center px-1 h-4 lg:px-3 lg:h-8 md:px-1 md:h-4 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            <i class="fa-solid fa-chevron-right"></i>
                        </li>`;
                    }

                    // Select page dropdown & total record
                    paginationHtml += `
                        <li class="mx-2" style="margin-left:10px;">
                            <a href="${page_view}" aria-current="page" class="z-10 flex items-center justify-center px-1 h-4 lg:px-3 lg:h-8 md:px-1 md:h-4 leading-tight text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">
                                <i class="fa-solid fa-filter-circle-xmark" style="color: #ff0000;"></i>
                            </a>
                        </li>
                        </ul>
                        <select onchange="set_page_dynamic_asset_new()" id="set_page_dynamic_asset_new" class="flex items-center justify-center px-1 h-8 lg:px-3 lg:h-8 md:px-1 md:h-8 text-sm leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">`;
                    if (page != 1)
                        paginationHtml += `<option value="${page}">${page}</option>`;
                    for (let i = 1; i <= totalPage; i++)
                        paginationHtml += `<option value="${i}">${i}</option>`;
                    paginationHtml += `</select>
                        <span class="font-bold flex justify-center items-center dark:text-slate-50">Found Page: ${totalPage} Pages &ensp;Total New Assets: ${totalRecord} Records</span>`;
                    pagination_search.innerHTML = paginationHtml;
                }
            }
            body_change.innerHTML = ``;

            data.data.map((item, index) => {
                let custom = ``;
                if (item.deleted == 1) {
                    custom += `
                             <tr   tabindex="0" class=" deleted_record bg-rose-100 border-b dark:bg-rose-800 dark:border-gray-700">
                                <td class="print_val ">
                                    <input onchange="printable()" data-id="{{ $item->assets_id }}"
                                        id="green-checkbox{{ $item->id }}" type="checkbox" value=""
                                        class="select_box w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <span class="px-2 ">Deleted</span>
                                              </td>
                        `;
                } else {
                    custom += `
                           <tr   tabindex="0" class="bg-white text-black  border-b dark:bg-gray-800 dark:text-white dark:border-gray-700">
                            <!-- Checkbox -->
                            <td class="print_val px-2 py-1 lg:px-6 lg:py-4 md:px-4 md:py-2">
                                <input onchange="printable()" data-id="${
                                    item.assets_id || ""
                                }"
                                    id="green-checkbox${
                                        item.id
                                    }" type="checkbox" value=""
                                    class="select_box w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded
                                    focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800
                                    focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                          </td>
                        `;
                }
                custom += `

        <!-- Asset ID -->
        <td class="px-2 py-1 lg:px-6 lg:py-4 md:px-4 md:py-2">
            ${item.assets_id || ""}
        </td>

        <!-- Transaction Date -->
        <td class="px-2 py-1 lg:px-6 lg:py-4 md:px-4 md:py-2">
            ${
                item.transaction_date
                    ? new Date(item.transaction_date)
                          .toLocaleDateString("en-GB", {
                              day: "2-digit",
                              month: "short",
                              year: "numeric",
                          })
                          .replace(/ /g, "-") // replace spaces with dashes
                    : ""
            }
        </td>

        <!-- Assets Code -->
        <td class="px-2 py-1 lg:px-6 lg:py-4 md:px-4 md:py-2">
            ${(item.assets1 || "") + (item.assets2 || "")}
        </td>

        <!-- Status -->
        <td class="px-2 py-1 lg:px-6 lg:py-4 md:px-4 md:py-2">
            ${
                item.status == 0
                    ? `
                        <span class="inline-flex items-center bg-red-100 text-red-800 text-xs font-medium
                        px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">
                            <span class="w-2 h-2 me-1 bg-red-500 rounded-full"></span>Inactive
                        </span>`
                    : `
                        <span class="inline-flex items-center bg-green-100 text-green-800 text-xs font-medium
                        px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
                            <span class="w-2 h-2 me-1 bg-green-500 rounded-full"></span>Active
                        </span>`
            }
        </td>
                <!-- Initial Condition -->
        <td class="px-2 py-1 lg:px-6 lg:py-4 md:px-4 md:py-2">${
            item.initial_condition || ""
        }</td>


        <!-- Item -->
        <td class="px-2 py-1 lg:px-6 lg:py-4 md:px-4 md:py-2">${
            item.item || ""
        }</td>

        <!-- Specification -->
        <td class="px-2 py-1 lg:px-6 lg:py-4 md:px-4 md:py-2">${
            item.specification || ""
        }</td>



        <!-- Holder -->
        <td class="px-2 py-1 lg:px-6 lg:py-4 md:px-4 md:py-2">${
            item.holder_name || ""
        }</td>

        <!-- Department -->
        <td class="px-2 py-1 lg:px-6 lg:py-4 md:px-4 md:py-2">${
            item.department || ""
        }</td>

        <!-- Company -->
        <td class="px-2 py-1 lg:px-6 lg:py-4 md:px-4 md:py-2">${
            item.company || ""
        }</td>

        <!-- Old Code -->
        <td class="px-2 py-1 lg:px-6 lg:py-4 md:px-4 md:py-2">${
            item.old_code || ""
        }</td>

        <!-- Reference -->
        <td class="px-2 py-1 lg:px-6 lg:py-4 md:px-4 md:py-2">${
            item.reference || ""
        }</td>
         <td class="px-2 py-1 lg:px-6 lg:py-4 md:px-4 md:py-2">${
             item.purpose || ""
         }</td>
          <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                                        ${
                                                            item.status_recieved ||
                                                            ""
                                                        }
                                                        </td>
        <!-- Created Date -->
        <td class="px-2 py-1 lg:px-6 lg:py-4 md:px-4 md:py-2">
            ${
                item.created_at
                    ? new Date(item.created_at)
                          .toLocaleDateString("en-GB", {
                              day: "2-digit",
                              month: "short",
                              year: "numeric",
                          })
                          .replace(/ /g, "-") // replace spaces with dashes
                    : ""
            }
        </td>
        <!-- Actions -->
        <td class="bg-gray-100 dark:bg-black text-gray-900 whitespace-nowrap dark:text-white">`;
                if (item.status == 1) {
                    custom += `
                                    <div class="option">
                                        <button id="dropdownMenuIconHorizontalButton${item.assets_id}"
                                            data-dropdown-toggle="dropdownDotsHorizontal${item.assets_id}"
                                            class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-900
                                            bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none
                                            dark:text-white focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700
                                            dark:focus:ring-gray-600"
                                            type="button">
                                               <i class="fa-solid fa-gear"></i>
                                        </button>

                                        <div id="dropdownDotsHorizontal${item.assets_id}"
                                            class="hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44
                                            dark:bg-gray-700 dark:divide-gray-600">
                                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                                aria-labelledby="dropdownMenuIconHorizontalButton${item.assets_id}">`;

                    // Movement
                    if (
                        auth?.permission?.transfer_write == 1 &&
                        item.deleted == 0
                    ) {
                        custom += `
                                                <li class="movement">
                                                    <a href="/admin/movement/add/detail/id=${item.assets_id}"
                                                       class="block px-4 py-2 hover:bg-gray-200  bg-white text-black dark:bg-black dark:text-white dark:hover:bg-white dark:hover:text-black">
                                                        Movement
                                                    </a>
                                                </li>`;
                    }

                    // View / Update

                    custom += `
                                <li>
                                    <a href="/admin/assets/data/view/id=${item.assets_id}/variant=${item.variant}"
                                        class="block px-4 py-2 hover:bg-gray-200  bg-white text-black dark:bg-black dark:text-white dark:hover:bg-white dark:hover:text-black">
                                        View
                                    </a>
                                </li>
                            `;

                    if (auth?.permission?.assets_update == 1) {
                        custom += `
                            <li>
                                <a href="/admin/assets/data/update/id=${item.assets_id}/variant=${item.variant}"
                                    class="block px-4 py-2 hover:bg-gray-200  bg-white text-black dark:bg-black dark:text-white dark:hover:bg-white dark:hover:text-black">
                                    Update
                                </a>
                            </li>
                            `;
                    }

                    // Delete
                    if (
                        auth?.permission?.assets_delete == 1 &&
                        item.deleted == 0
                    ) {
                        custom += `

                                                     <li class="cursor block px-4 py-2 hover:bg-gray-200 bg-white text-black dark:bg-black dark:text-white dark:hover:bg-white dark:hover:text-black"
                                                        data-id="${item.assets_id}"
                                                        id="btn_delete_asset${item.assets_id}"
                                                        onclick="openDeleteModal('btn_delete_asset${item.assets_id}')">
                                                        Delete
                                                    </li>

                                                `;
                    }

                    custom += `
                                                                            </ul>
                                                                        </div>
                                                                    </div>`;
                } else {
                    custom += `
                         <a
                                            href="/admin/assets/data/view/id=${item.assets_id}/variant=${item.variant}">
                                            <button data-popover-target="popover-default${index}"
                                                type="button"
                                                class="text-black mx-2 bg-grey-100 hover:bg-grey-200 focus:ring-4 focus:outline-none focus:ring-blue-100 font-medium rounded-lg text-sm px-2.5 py-2 text-center dark:bg-gray-900 dark:hover:bg-gray-200 dark:focus:ring-gray-300 dark:text-white">

                                                <i class="fa-solid fa-eye "></i>
                                            </button>
                                        </a>
                        `;
                }

                custom += `</td>
                            </tr>`;
                body_change.innerHTML += custom;
            });
            initFlowbite();
            // array = data.data
        } else {
            body_change.innerHTML = "";
            toast_red.querySelector("p").innerHTML = "Data not Found.";
            pagination_search.innerHTML = `
                  <div class="flex main_page ">
                                <span class="font-bold flex justify-center items-center dark:text-slate-50">Data Not Found</span>
                                <ul class="flex items-center -space-x-px h-8 text-sm">
                                    <li class="mx-2" style="margin-left:10px;">
                                                <a href="0" aria-current="page"
                                                class="z-10 flex items-center justify-center px-1 h-4   lg:px-3 lg:h-8  md:px-1 md:h-4 leading-tight text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">
                                                <i class="fa-solid fa-filter-circle-xmark" style="color: #ff0000;">
                                                </i>
                                            </a>
                                        </li>
                                </ul>
                            </div>

                `;
            toast_red.style.display = "block";
            toast_red.style.animation = "none";
            toast_red.offsetHeight;
            toast_red.style.animation = "fadeOut2 4s forwards";
        }
    } else {
        toast_red.querySelector("p").innerHTML =
            "Problem on database connection.";
        pagination_search.innerHTML = `
                  <div class="flex main_page ">
                                <span class="font-bold flex justify-center items-center dark:text-slate-50">Data Not Found</span>
                                <ul class="flex items-center -space-x-px h-8 text-sm">
                                    <li class="mx-2" style="margin-left:10px;">
                                                <a href="0" aria-current="page"
                                                class="z-10 flex items-center justify-center px-1 h-4   lg:px-3 lg:h-8  md:px-1 md:h-4 leading-tight text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">
                                                <i class="fa-solid fa-filter-circle-xmark" style="color: #ff0000;">
                                                </i>
                                            </a>
                                        </li>
                                </ul>
                            </div>

                `;
        toast_red.style.display = "block";
        toast_red.style.animation = "none";
        toast_red.offsetHeight;
        toast_red.style.animation = "fadeOut2 4s forwards";
    }
}

async function showLoader(asyncTask) {
    const loadingDiv = document.getElementById("loading");
    const percentText = document.getElementById("percent_text");
    const progressBar = document.getElementById("progress_bar");
    const loadingText = document.getElementById("loading_text");

    if (!loadingDiv || !percentText || !progressBar || !loadingText) return;

    // Show loader
    loadingDiv.classList.remove("hidden");
    loadingDiv.style.opacity = "1";

    // Reset UI
    progressBar.style.width = "0%";
    percentText.innerText = "0%";

    let progress = 0;
    let finished = false;

    // Smooth progress simulation
    const interval = setInterval(() => {
        if (!finished) {
            progress += Math.random() * 5 + 1; // slow increment
            if (progress > 95) progress = 95; // cap until task finishes
        } else {
            progress += 2; // finish fast
            if (progress >= 100) progress = 100;
        }
        progressBar.style.width = progress + "%";
        percentText.innerText = Math.floor(progress) + "%";
    }, 100);

    // Run your async task
    let result;
    try {
        result = await asyncTask();
        finished = true;
    } catch (err) {
        console.error(err);
        finished = true;
        throw err;
    }

    // Ensure 100% at the end
    progressBar.style.width = "100%";
    percentText.innerText = "100%";
    clearInterval(interval);

    // Fade out
    setTimeout(() => {
        loadingDiv.style.opacity = "0";
        setTimeout(() => {
            loadingDiv.classList.add("hidden");
        }, 500);
    }, 500);

    return result;
}

async function change_toggle(state) {
    const url = `/api/fect/assets/toggle`;

    try {
        const response = await fetch(url, {
            method: "POST",
            headers: {
                Authorization: `Bearer ${token}`,
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                type: "minimize",
                value: state,
                id: auth.id,
                _t: Date.now(),
            }),
        });

        const data = await response.json();

        console.log("Toggle state saved:", data); // will be 1 or 0
    } catch (error) {
        console.error("Error saving toggle state:", error);
    }
}

let state_toggle_table = 1; // 0 = collapsed, 1 = expanded

function adjustLayout() {
    // 🔹 Toggle search bar
    let searchBar = document.querySelector(".search-bar");
    searchBar?.classList.toggle("hidden");

    // 🔹 Adjust scroll container & table height
    let scrollContainer = document.querySelector(".scroll-container");
    if (scrollContainer) {
        scrollContainer.style.height = state_toggle_table ? "80vh" : "60vh";
    }

    let tableData = document.querySelector(".table-data");
    if (tableData) {
        tableData.style.height = state_toggle_table ? "90vh" : "60vh";
    }

    // 🔹 Switch icon
    let icon = document.getElementById("toggleIcon"); // make sure your <i> has this id
    if (icon) {
        if (state_toggle_table) {
            icon.classList.remove("fa-maximize");
            icon.classList.add("fa-minimize");
        } else {
            icon.classList.remove("fa-minimize");
            icon.classList.add("fa-maximize");
        }
    }

    // 🔹 Toggle state for next click
    state_toggle_table = state_toggle_table === 0 ? 1 : 0;
}
function showToastRed(message) {
    const toast = document.getElementById("toast_red");
    if (!toast) {
        console.warn("Toast element not found");
        return;
    }

    toast.textContent = message; // safer than innerText
    toast.style.display = "block";
    toast.style.opacity = "1";

    if (toast.timer) clearTimeout(toast.timer);

    toast.timer = setTimeout(() => {
        toast.style.opacity = "0";
        setTimeout(() => (toast.style.display = "none"), 500);
    }, 3000);
}

function showSuccessToast(message = "Success") {
    const toast = document.getElementById("toast_green");
    const label = document.getElementById("toast_green_label");

    label.innerText = message;

    toast.style.display = "block";
    toast.style.opacity = 1;
    toast.style.visibility = "visible";
    toast.style.animation = "none";
    void toast.offsetWidth; // trigger reflow
    toast.style.animation = "fadeOut2 7s forwards";

    setTimeout(() => (toast.style.display = "none"), 4000);
}

function showErrorToast(message = "Error") {
    const toast = document.getElementById("toast_red");
    const label = document.getElementById("toast_red_label");

    label.innerText = message;

    toast.style.display = "block";
    toast.style.opacity = 1;
    toast.style.visibility = "visible";
    toast.style.animation = "none";
    void toast.offsetWidth; // trigger reflow
    toast.style.animation = "fadeOut2 4s forwards";

    setTimeout(() => (toast.style.display = "none"), 4000);
}
function validateInputField(field, maxLength) {
    if (field.value.length > maxLength) {
        field.value = field.value.substring(0, maxLength);
        showToastRed("Maximum " + maxLength + " characters allowed!");
    }
}
function validateInputField_assets(input, maxLength) {
    // Allowed characters: English letters, digits, common symbols, spaces
    const pattern = /^[A-Za-z0-9\s`~!@#$%^&*()_\-+={}[\]|\\:;"'<>,.?/]*$/;

    // Trim input to max length
    if (input.value.length > maxLength) {
        input.value = input.value.slice(0, maxLength);
    }

    // Remove disallowed characters
    if (!pattern.test(input.value)) {
        // Replace invalid characters
        input.value = input.value.replace(
            /[^A-Za-z0-9\s`~!@#$%^&*()_\-+={}[\]|\\:;"'<>,.?/]/g,
            ""
        );
        showToastRed("Other Scipt is not allowed on Assets Code!");
    }
}
