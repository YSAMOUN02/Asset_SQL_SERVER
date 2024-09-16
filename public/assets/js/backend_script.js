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

if (localStorage.getItem("theme") === "dark") {
    document.documentElement.classList.add("dark");
}

const toggleDarkMode = () => {
    const htmlElement = document.documentElement;
    htmlElement.classList.toggle("dark");

    if (htmlElement.classList.contains("dark")) {
        localStorage.setItem("theme", "dark");
    } else {
        localStorage.setItem("theme", "light");
    }
};

document
    .getElementById("dark-mode-toggle")
    .addEventListener("click", toggleDarkMode);

function delete_value(btn_delete, toast, toast_input) {
    let id = document.querySelector("#" + btn_delete).getAttribute("data-id");
    console.log(id);
    //  Toast Show

    document.querySelector("#" + toast).style.display = "block";

    // assign value to input
    document.querySelector("#" + toast_input).value = id;
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
                                <img id="${box}" onclick="maximize_minimize(${state_box})"  src="/uploads/image/{{ $item->image }}"
                           
                                    alt="Item">
                              

                                <button type="button" id="delete_image" onclick="remove_image(${state_box})"><i class="fa-solid fa-trash"
                                        style="color: #ff0000;"></i>


                                <a download="{{ $item->image }}" href="/uploads/image/{{ $item->image }}"><button
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
    document.querySelector("#image_state").value = state_box;

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
        alert(
            "File is Unknown! , FIle allow is  PDF , PPTX, DOCX , ZIP , RAR."
        );
    }
}

function maximize_minimize(id) {
    var url = document.querySelector("#box" + id).src;
    // Create a new window or tab
    var newWindow = window.open("", "_blank");
    // Add the image to the new window and style it for full screen
    newWindow.document.write(
        `<html><head><title>Full Screen Image</title></head><body style="margin:0;"><img src="${url}" style="width:100vw; height:100vh; object-fit:contain;"></body></html>`
    );
    newWindow.document.close(); // Close the document to render the content
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
    let id = document.querySelector("#Asset_Code").value;

    if (id) {
        let url = `/api/assets/${id}`;

        let data = await fetch(url)
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

        if (data != "Data not Found") {
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
                            <tr>
                                <th scope="col" class="px-6 py-3">Posting Date</th>
                                <th scope="col" class="px-6 py-3">Assets</th>
                                <th scope="col" class="px-6 py-3">FA</th>
                                <th scope="col" class="px-6 py-3">Invoice No</th>
                                <th scope="col" class="px-6 py-3">Description</th>
                                <th scope="col" class="px-6 py-3">Invoice Description</th>
                                <th scope="col" class="px-6 py-3">Cost</th>
                                <th scope="col" class="px-6 py-3">Currency</th>
                                <th scope="col" class="px-6 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody class="sticky top-0">
                            ${data
                                .map(
                                    (item, index) => `
                                <tr class=" bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="px-6 py-4">
                                      ${
                                          item.posting_date
                                              ? new Date(
                                                    item.posting_date
                                                ).toLocaleDateString("en-US", {
                                                    year: "numeric",
                                                    month: "short",
                                                    day: "numeric",
                                                })
                                              : ""
                                      }
                                    </td>
                                    <td class="px-6 py-4 no_wrap">${
                                        item.assets || ""
                                    }</td>
                                    <td class="px-6 py-4 no_wrap">${
                                        item.fa || ""
                                    }</td>
                                    <td class="px-6 py-4 no_wrap">${
                                        item.invoice_no || ""
                                    }</td>
                                    <td class="px-6 py-4">${
                                        item.description || ""
                                    }</td>
                                    <td class="px-6 py-4">${
                                        item.fa_description || ""
                                    }</td>
                                    <td class="px-6 py-4">${
                                        parseFloat(item.cost) || ""
                                    }</td>
                                    <td class="px-6 py-4">${
                                        item.currency || ""
                                    }</td>
                                    <td class="px-6 py-4">
                                        <button type="button"  onclick="assets_invoice_choose(${index})"
                                        class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 shadow-lg shadow-purple-500/50 dark:shadow-lg dark:shadow-purple-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                                        Select</button>
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
            alert(data);
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
    if (cost) cost.value = parseFloat(data_invoice[index].cost);

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
}

async function raw_assets() {
    let Assets = document.querySelector("#assets");
    let Fa = document.querySelector("#fa");
    let Invoice = document.querySelector("#invoice");
    let Description = document.querySelector("#description");
    let StartDate = document.querySelector("#start_date");
    let EndDate = document.querySelector("#end_date");
    let State = document.querySelector("#state");

    let startDateValue = StartDate.value;
    let endDateValue = EndDate.value;

    let startDate = new Date(startDateValue);
    let endDate = new Date(endDateValue);

    if (startDate > endDate) {
        console.log("Start Date is greater.Select Correct Date and Try again.");
        alert(
            "Start Date is greater than End Date.Please select correct date and Try again."
        );
        return;
    }
    let fa_value;

    if (Fa) {
        if (Fa.value != "") {
            fa_value = Fa.value.replace(/\//g, "-");
        } else {
            fa_value = "NA";
        }
    }

    let invoice_value;

    if (Invoice) {
        if (Invoice.value != "") {
            // Assume Fa.value is a string
            invoice_value = Invoice.value.replace(/\//g, "-");
        } else {
            invoice_value = "NA";
        }
    }

    let description_value;

    if (Description) {
        if (Description.value != "") {
            description_value = Description.value.replace(/\//g, "-");
        } else {
            description_value = "NA";
        }
    }

    let url = `/api/RawAssets/assets=${
        Assets.value || "NA"
    }/fa=${fa_value}/invoice=${invoice_value}/description=${description_value}/start=${
        StartDate.value || "NA"
    }/end=${EndDate.value || "NA"}/state=${State.value || "NA"}`;

    let data = await fetch(url)
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
            console.error(
                "There was a problem with the fetch operation:",
                error
            );
        });

    let body_table = document.querySelector("#table_raw_body");
    console.log(data);
    if (data) {
        body_table.innerHTML = `
                ${data
                    .map(
                        (item, index) => `
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                ${index + 1}
                            </td>
                            <td scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    ${
                                        item.posting_date
                                            ? new Date(
                                                  item.posting_date
                                              ).toLocaleDateString("en-US", {
                                                  year: "numeric",
                                                  month: "short",
                                                  day: "numeric",
                                              })
                                            : ""
                                    }
                            </td>
                            <td scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                               ${item.assets}
                            </td>
                            <td scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                ${item.fa}
                            </td>
                            <td scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                ${item.invoice_no}
                            </td>
                            <td scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                ${item.description}
                            </td>
                            <td class="px-6 py-4">
                                <a href="/admin/assets/add/assets=${
                                    item.assets
                                }/invoice_no=${
                            item.fa ? item.fa.replace(/\//g, "-") : "NA"
                        }"
                                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Select</a>
                            </td>
                        </tr>
                    `
                    )
                    .join("")}
            `;
    }
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

FusionCharts.ready(async function () {
    let url = "/api/assets_status";
    let jsonData2 = await fetch(url)
        .then((response) => {
            if (!response.ok) {
                throw new Error("Network response was not ok");
            }
            return response.json(); // Parse the JSON response directly
        })
        .then((data) => {
            return data; // Handle your JSON data as a JavaScript object
        })
        .catch((error) => {
            console.error(
                "There was a problem with the fetch operation:",
                error
            );
        });

    // Original calendar array
    let calendar = [
        { label: "jan", value: 0 },
        { label: "feb", value: 0 },
        { label: "mar", value: 0 },
        { label: "apr", value: 0 },
        { label: "may", value: 0 },
        { label: "jun", value: 0 },
        { label: "jul", value: 0 },
        { label: "aug", value: 0 },
        { label: "sep", value: 0 },
        { label: "oct", value: 0 },
        { label: "nov", value: 0 },
        { label: "dec", value: 0 },
    ];

    // Convert the calendar array to a map for fast lookup
    let calendarMap = new Map(calendar.map((month) => [month.label, month]));

    const monthAbbreviations = [
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "May",
        "Jun",
        "Jul",
        "Aug",
        "Sep",
        "Oct",
        "Nov",
        "Dec",
    ];

    const currentDate = new Date();
    const currentMonthIndex = currentDate.getMonth(); // Zero-based index
    const currentMonthAbbreviation = monthAbbreviations[currentMonthIndex];

    let val = 0;
    // Update the values from jsonData2
    jsonData2.forEach((data) => {
        let lowerCaseLabel = data.label.toLowerCase();
        if (calendarMap.has(lowerCaseLabel)) {
            calendarMap.get(lowerCaseLabel).value = Number(data.value);
            if (currentMonthAbbreviation == data.label) {
                val = data.value;
            }
        }
    });

    // Convert the map back to an array if needed
    calendar = Array.from(calendarMap.values());
    var chartObj = new FusionCharts({
        type: "column2d",
        renderAt: "chart-container",
        width: "680",
        height: "390",
        dataFormat: "json",
        dataSource: {
            chart: {
                caption: "Assets Created by Month",

                xAxisName: "Month",
                yAxisName: "Asset Data",
                numberPrefix: "Created Assets: ",
                theme: "fusion",
            },
            data: calendar,
            trendlines: [
                {
                    line: [
                        {
                            startvalue: val,
                            valueOnRight: "1",
                            displayvalue: "This Month",
                        },
                    ],
                },
            ],
        },
    });
    chartObj.render();
});

FusionCharts.ready(async function () {
    let url = "/api/fixAsset/location";
    let jsonData = await fetch(url)
        .then((response) => {
            if (!response.ok) {
                throw new Error("Network response was not ok");
            }
            return response.json(); // Parse the JSON response directly
        })
        .then((data) => {
            return data; // Handle your JSON data as a JavaScript object
        })
        .catch((error) => {
            console.error(
                "There was a problem with the fetch operation:",
                error
            );
        });

    var chartObj = new FusionCharts({
        type: "doughnut3d",
        renderAt: "chart-container-round",
        width: "550",
        height: "450",
        dataFormat: "json",
        dataSource: {
            chart: {
                caption: "Assets ",
                subCaption: "All Year",
                numberPrefix: "$",
                bgColor: "#ffffff",
                startingAngle: "310",
                showLegend: "1",
                defaultCenterLabel: "Total revenue: $64.08K",
                centerLabel: "Revenue from $label: $value",
                centerLabelBold: "1",
                showTooltip: "0",
                decimals: "0",
                theme: "fusion",
            },
            data: jsonData, // Pass the parsed JavaScript object
        },
    });
    chartObj.render();
});

function dynamic_sort(by, method, table) {
    if (method == "int") {
        if (sort_state == 0) {
            // Sort by the specified property in ascending order
            array.sort((a, b) => a[by] - b[by]);
            sort_state = 1;
        } else {
            // Sort by the specified property in descending order
            array.sort((a, b) => b[by] - a[by]);
            sort_state = 0;
        }
    } else if (method == "string") {
        if (sort_state == 0) {
            // Sort by 'change' (ascending order)
            array.sort((a, b) => a[by].localeCompare(b[by]));
            sort_state = 1;
        } else {
            // Sort by 'change' (descending order)
            array.sort((a, b) => b[by].localeCompare(a[by]));
            sort_state = 0;
        }
    } else if (method == "date") {
        if (sort_state == 0) {
            console.log("sort date called");
            // Sort by the specified date property in ascending order

            array.sort((a, b) => {
                let dateA = new Date(a[by]);
                let dateB = new Date(b[by]);

                // Handle invalid dates
                if (isNaN(dateA)) return 1; // Push invalid dates to the end
                if (isNaN(dateB)) return -1; // Push invalid dates to the end

                return dateA - dateB; // Compare dates in ascending order
            });
            sort_state = 1;
        } else {
            // Sort by the specified date property in descending order
            array.sort((a, b) => {
                let dateA = new Date(a[by]);
                let dateB = new Date(b[by]);

                // Handle invalid dates
                if (isNaN(dateA)) return 1; // Push invalid dates to the end
                if (isNaN(dateB)) return -1; // Push invalid dates to the end

                return dateB - dateA; // Compare dates in descending order
            });
            sort_state = 0;
        }
    }
    if (table == "assets") {
        show_sort_asset();
    } else if (table == "changelog") {
        show_sort_change_log();
    } else if (table == "raw_assets") {
        show_sort_raw_asset();
    } else if (table == "quick") {
        show_sort_quick_data();
    } else if (table == "asset_staff") {
        show_sort_staff_asset();
    }
}

function show_sort_staff_asset() {
    let body_change = document.querySelector("#asset_staff_body");
    body_change.innerHTML = ``;
    array.map((item) => {
        body_change.innerHTML += `
        
     <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="px-6 py-4">
                                        ${item.id || ""}
                                    </td>
                                    <td class="px-6 py-4">
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
                                    <td class="px-6 py-4">
                                          ${item.document || ""}
                                    </td>

                                    <td class="px-6 py-4">
                                             ${
                                                 item.assets1 + item.assets2 ||
                                                 ""
                                             }
                                    </td>
                                    <td class="px-6 py-4">
                                ${item.fa || ""}
                                    </td>
                                    <td class="px-6 py-4">
                                 ${item.fa_type || ""}
                                    </td>
                                    <td class="px-6 py-4">
                               ${item.fa_class || ""}
                                    </td>
                                    <td class="px-6 py-4">
                                      ${item.fa_subclass || ""}
                                    </td>
                                    <td class="px-6 py-4">
                                           ${item.depreciation || ""}
                                    </td>
                                    <td class="px-6 py-4">
                                       ${item.dr || ""}
                                    </td>
                                    <td class="px-6 py-4">
                                        ${item.pr || ""}
                                    </td>
                                    <td class="px-6 py-4">
                                        ${item.invoice_no || ""}
                                       
                                    </td>
                                    <td class="px-6 py-4">
                                         ${item.description || ""}
                                    </td>
                                  <td class="px-6 py-4 dark:bg-slate-900"
                                    style="position: sticky; right: 0; background-color: white;">
                                    ${(auth?.permission?.assets_read == 1  & auth?.permission?.assets_update == 0)?
                                   
                                        `   <button type="button"
                                            class="text-white bg-gradient-to-r from-purple-300 via-purple-500 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-500 dark:focus:ring-green-500 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                                            <i class="fa-solid fa-eye" style="color: #ffffff;"></i>
                                        </button>
                                        `
                                        : `` }

                                    ${
                                        auth?.permission?.assets_update == 1
                                            ? `
                                                <a href="/admin/assets/edit/id=${item.id}">
                                                    <button type="button"
                                                        class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"><i
                                                            class="fa-solid fa-pen-to-square" style="color: #ffffff;"></i>
                                                    </button>
                                                 </a>
                                            `
                                            : // If auth.permission.assets_write is 1
                                              `` // If not, show nothing
                                    }
                                    ${
                                        auth?.permission?.assets_delete == 1
                                            ? `
                                                 <button type="button" data-id="${item.id}"
                                                    id="btn_delete_asset${item.id}"
                                                    onclick="delete_value('btn_delete_asset'+${item.id},'delete_asset_admin','delete_value_asset')"
                                                    class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                                                    <i class="fa-solid fa-trash" style="color: #ffffff;"></i></button>
                                            `
                                            : // If auth.permission.assets_write is 1
                                              `` // If not, show nothing
                                    }

                                    
                                </td>


                                </tr>
  `;
    });
}
function show_sort_quick_data() {
    let body_change = document.querySelector("#body_quick_data");
    body_change.innerHTML = ``;
    array.map((item) => {
        body_change.innerHTML += `
        
    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                       <td scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            ${item.id}
                        </td>
                        <td scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                 ${item.content}
                        </td>
                        <td scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                 ${item.type}
                        </td>
                                 <td scope="row"
                                        class=" px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">


                                        <button type="button" data-modal-target="small-modal"
                                            data-modal-toggle="small-modal"
                                            onclick="update_quick_data(${item.id})"
                                            class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"><i
                                                class="fa-solid fa-pen-to-square" style="color: #ffffff;"></i>
                                        </button>
                                        <!-- Modal toggle -->


                        <button type="button" data-id="${item.id}"
                            id="btn_delete${item.id}"
                                onclick="delete_value('btn_delete'+${item.id},'delete_data','delete_data_value')"
                            class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                            <i class="fa-solid fa-trash" style="color: #ffffff;"></i>
                        </button>
                        </td>
                   </tr>
  `;
    });
}
function show_sort_change_log() {
    let body_change = document.querySelector("#table_body_change");
    body_change.innerHTML = ``;
    array.map((item) => {
        body_change.innerHTML += `
        
    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                       <td class="px-6 py-4">
                           ${item.id || ""}
                       </td>
                       <td class="px-6 py-4">
                            ${item.key || ""}
                       </td>
                       <td class="px-6 py-4">
                          ${item.varaint || ""}
                       </td>
                       <td class="px-6 py-4">
                          ${item.change || ""}
                       </td>
                       <td class="px-6 py-4">
                          ${item.section || ""}
                       </td>
                       <td class="px-6 py-4">
                          ${item.users.name || ""}
                       </td>
                       <td class="px-6 py-4">
                        ${item.users.role || ""}
                       </td>
                       <td class="px-6 py-4"> 
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
}

function show_sort_asset() {
    let body_change = document.querySelector("#assets_body");
    body_change.innerHTML = ``;
    array.map((item) => {
        body_change.innerHTML += `
        
     <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="px-6 py-4">
                                        ${item.assets_id || ""}
                                    </td>
                                    <td class="px-6 py-4">
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
                                    <td class="px-6 py-4">
                                          ${item.document || ""}
                                    </td>

                                    <td class="px-6 py-4">
                                             ${
                                                 item.assets1 + item.assets2 ||
                                                 ""
                                             }
                                    </td>
                                    <td class="px-6 py-4">
                                ${item.fa || ""}
                                    </td>
                                    <td class="px-6 py-4">
                                 ${item.fa_type || ""}
                                    </td>

                                        <td class="px-6 py-4">
                               ${(item.deleted==0)?
                                `  <span
                                        class="inline-flex items-center bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
                                        <span class="w-2 h-2 me-1 bg-green-500 rounded-full"></span>
                                        Available
                                    </span>
                                    `:
                                `
                                         <span
                                        class="inline-flex items-center bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">
                                        <span class="w-2 h-2 me-1 bg-red-500 rounded-full"></span>
                                        Deleted
                                    </span>
                                `
                               }
                                    </td>
                                    <td class="px-6 py-4">
                               ${item.fa_class || ""}
                                    </td>
                                    <td class="px-6 py-4">
                                      ${item.fa_subclass || ""}
                                    </td>
                                    <td class="px-6 py-4">
                                           ${item.depreciation || ""}
                                    </td>
                                    <td class="px-6 py-4">
                                       ${item.dr || ""}
                                    </td>
                                    <td class="px-6 py-4">
                                        ${item.pr || ""}
                                    </td>
                                    <td class="px-6 py-4">
                                        ${item.invoice_no || ""}
                                       
                                    </td>
                                    <td class="px-6 py-4">
                                         ${item.description || ""}
                                    </td>
                                  <td class="px-6 py-4 dark:bg-slate-900"
                                    style="position: sticky; right: 0; background-color: white;">
                                    ${
                                        auth?.permission?.assets_write == 1
                                            ? `
                                                <a href="/admin/assets/edit/id=${item.assets_id}">
                                                    <button type="button"
                                                        class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"><i
                                                            class="fa-solid fa-pen-to-square" style="color: #ffffff;"></i>
                                                    </button>
                                                 </a>
                                            `
                                            : // If auth.permission.assets_write is 1
                                              `` // If not, show nothing
                                    }
                                    ${
                                        auth?.permission?.assets_delete == 1
                                            ? `
                                                 <button type="button" data-id="${item.assets_id}"
                                                    id="btn_delete_asset${item.assets_id}"
                                                    onclick="delete_value('btn_delete_asset'+${item.assets_id},'delete_asset_admin','delete_value_asset')"
                                                    class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                                                    <i class="fa-solid fa-trash" style="color: #ffffff;"></i></button>
                                            `
                                            : // If auth.permission.assets_write is 1
                                              `` // If not, show nothing
                                    }

                                    
                                </td>


                                </tr>
  `;
    });
}
function show_sort_raw_asset() {
    let body_change = document.querySelector("#table_raw_body");
    body_change.innerHTML = ``;
    array.map((item, index) => {
        body_change.innerHTML += `
   
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">

                                            <td scope="row"
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                ${index + 1}
                                            </td>
                                            <td scope="row"
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                               

                                                  ${
                                                      item.assets_date
                                                          ? new Date(
                                                                item.assets_date
                                                            ).toLocaleDateString(
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
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                ${item.assets}
                                            </td>
                                            <td scope="row"
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                ${item.fa || ""}
                                            </td>

                                            <td scope="row"
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                ${item.invoice_no}
                                            </td>
                                            <td scope="row"
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                ${item.description}
                                            </td>


                                            <td class="px-6 py-4">
                                                <a href="/admin/assets/add/assets=${
                                                    item.assets
                                                }/invoice_no=${item.fa.replace(
            /\//g,
            "-"
        )}"
                                                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Select</a>
                                            </td>

                                        </tr>

            `;
    });
}
function update_quick_data(item) {
    let content = document.querySelector("#content_update");
    let type = document.querySelector("#type_update");
    let id = document.querySelector("#id_update");
    if (content) {
        content.value = item.content;
    }
    if (type) {
        type.value = item.type;
    }
    if (id) {
        id.value = item.id;
    }
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
