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
            "File is Unknown! , FIle allow is  JPG  JPEG  GIF PNG"
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
                            <tr>
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
                                <tr class=" bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="px-1 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
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
                                    <td class="px-1 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  no_wrap">${
                                        item.assets || ""
                                    }</td>
                                    <td class="px-1 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  no_wrap">${
                                        item.fa || ""
                                    }</td>
                                    <td class="px-1 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  no_wrap">${
                                        item.invoice_no || ""
                                    }</td>
                                    <td class="px-1 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">${
                                        item.description || ""
                                    }</td>
                                    <td class="px-1 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">${
                                        item.fa_description || ""
                                    }</td>
                                    <td class="px-1 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">${
                                        parseFloat(item.cost) || ""
                                    }</td>
                                    <td class="px-1 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">${
                                        item.currency || ""
                                    }</td>
                                    <td class="px-1 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                        <button type="button"  onclick="assets_invoice_choose(${index})"
                                        class="scale-50 lg:scale-100 text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 shadow-lg shadow-purple-500/50 dark:shadow-lg dark:shadow-purple-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
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

// FusionCharts.ready(async function () {
//     let url = "/api/assets_status";
//     let jsonData2 = await fetch(url)
//         .then((response) => {
//             if (!response.ok) {
//                 throw new Error("Network response was not ok");
//             }
//             return response.json(); // Parse the JSON response directly
//         })
//         .then((data) => {
//             return data; // Handle your JSON data as a JavaScript object
//         })
//         .catch((error) => {
//             console.error(
//                 "There was a problem with the fetch operation:",
//                 error
//             );
//         });

//     // Original calendar array
//     let calendar = [
//         { label: "jan", value: 0 },
//         { label: "feb", value: 0 },
//         { label: "mar", value: 0 },
//         { label: "apr", value: 0 },
//         { label: "may", value: 0 },
//         { label: "jun", value: 0 },
//         { label: "jul", value: 0 },
//         { label: "aug", value: 0 },
//         { label: "sep", value: 0 },
//         { label: "oct", value: 0 },
//         { label: "nov", value: 0 },
//         { label: "dec", value: 0 },
//     ];

//     // Convert the calendar array to a map for fast lookup
//     let calendarMap = new Map(calendar.map((month) => [month.label, month]));

//     const monthAbbreviations = [
//         "Jan",
//         "Feb",
//         "Mar",
//         "Apr",
//         "May",
//         "Jun",
//         "Jul",
//         "Aug",
//         "Sep",
//         "Oct",
//         "Nov",
//         "Dec",
//     ];

//     const currentDate = new Date();
//     const currentMonthIndex = currentDate.getMonth(); // Zero-based index
//     const currentMonthAbbreviation = monthAbbreviations[currentMonthIndex];

//     let val = 0;
//     // Update the values from jsonData2
//     jsonData2.forEach((data) => {
//         let lowerCaseLabel = data.label.toLowerCase();
//         if (calendarMap.has(lowerCaseLabel)) {
//             calendarMap.get(lowerCaseLabel).value = Number(data.value);
//             if (currentMonthAbbreviation == data.label) {
//                 val = data.value;
//             }
//         }
//     });

//     // Convert the map back to an array if needed
//     calendar = Array.from(calendarMap.values());
//     var chartObj = new FusionCharts({
//         type: "column2d",
//         renderAt: "chart-container",
//         width: "680",
//         height: "390",
//         dataFormat: "json",
//         dataSource: {
//             chart: {
//                 caption: "Assets Created by Month",

//                 xAxisName: "Month",
//                 yAxisName: "Asset Data",
//                 numberPrefix: "Created Assets: ",
//                 theme: "fusion",
//             },
//             data: calendar,
//             trendlines: [
//                 {
//                     line: [
//                         {
//                             startvalue: val,
//                             valueOnRight: "1",
//                             displayvalue: "This Month",
//                         },
//                     ],
//                 },
//             ],
//         },
//     });
//     chartObj.render();
// });

// FusionCharts.ready(async function () {
//     let url = "/api/fixAsset/location";
//     let jsonData = await fetch(url)
//         .then((response) => {
//             if (!response.ok) {
//                 throw new Error("Network response was not ok");
//             }
//             return response.json(); // Parse the JSON response directly
//         })
//         .then((data) => {
//             return data; // Handle your JSON data as a JavaScript object
//         })
//         .catch((error) => {
//             console.error(
//                 "There was a problem with the fetch operation:",
//                 error
//             );
//         });

//     var chartObj = new FusionCharts({
//         type: "doughnut3d",
//         renderAt: "chart-container-round",
//         width: "550",
//         height: "450",
//         dataFormat: "json",
//         dataSource: {
//             chart: {
//                 caption: "Assets ",
//                 subCaption: "All Year",
//                 numberPrefix: "$",
//                 bgColor: "#ffffff",
//                 startingAngle: "310",
//                 showLegend: "1",
//                 defaultCenterLabel: "Total revenue: $64.08K",
//                 centerLabel: "Revenue from $label: $value",
//                 centerLabelBold: "1",
//                 showTooltip: "0",
//                 decimals: "0",
//                 theme: "fusion",
//             },
//             data: jsonData, // Pass the parsed JavaScript object
//         },
//     });
//     chartObj.render();
// });

function dynamic_sort(by, method, table) {
    // Check if array length is less than or equal to 500

    if (array) {
        if (array.length <= 500) {
            // Show loading panel
            document.querySelector("#loading").style.display = "block";

            // Wrap the sorting operation in a setTimeout to simulate the loading panel
            setTimeout(() => {
                // Sorting by integer
                if (method == "int") {
                    if (sort_state == 0) {
                        array.sort((a, b) => a[by] - b[by]); // Ascending
                        sort_state = 1;
                    } else {
                        array.sort((a, b) => b[by] - a[by]); // Descending
                        sort_state = 0;
                    }
                }
                // Sorting by string
                else if (method == "string") {
                    if (sort_state == 0) {

                        array.sort((a, b) => a[by].localeCompare(b[by])); // Ascending
                        sort_state = 1;
                    } else {
                        array.sort((a, b) => b[by].localeCompare(a[by])); // Descending
                        sort_state = 0;
                    }
                }
                // Sorting by date
                else if (method == "date") {
                    if (sort_state == 0) {
                        array.sort((a, b) => {
                            let dateA = new Date(a[by]);
                            let dateB = new Date(b[by]);
                            if (isNaN(dateA)) return 1; // Invalid date to end
                            if (isNaN(dateB)) return -1; // Invalid date to end
                            return dateA - dateB; // Ascending
                        });
                        sort_state = 1;
                    } else {
                        array.sort((a, b) => {
                            let dateA = new Date(a[by]);
                            let dateB = new Date(b[by]);
                            if (isNaN(dateA)) return 1; // Invalid date to end
                            if (isNaN(dateB)) return -1; // Invalid date to end
                            return dateB - dateA; // Descending
                        });
                        sort_state = 0;
                    }
                }

                // Show sorted table data based on the table type
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
                } else if (table == "users") {
                    show_sort_user();
                }   else if(table == "movement"){
                    show_sort_movement();
                }

                // Hide loading panel after sorting is done
                document.querySelector("#loading").style.display = "none";
            }, 500); // Adjust the timeout as needed
        } else {
            alert("Data too Big. Sorting might crash your browser.");
        }
    } else {
        alert("Data not valid.");
    }
}

function show_sort_movement(){
    let body_change = document.querySelector("#movement_body");
    if (body_change) {
        body_change.innerHTML = ``;

        array.map((item) => {
            let custom = ``;

             custom += `<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
               `;

            custom += `
                         <td scope="row"
                              class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white">
                              ${item.id}
                          </td>
                            <td scope="row"
                              class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white">
                         ${
                                                                item.created_at
                                                                    ? new Date(
                                                                            item.created_at
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
                              class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white">
                              ${item.movement_no}
                          </td>
                            <td scope="row"
                              class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white">
                              ${item.assets_no}
                          </td>
                               <td scope="row"
                              class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white">
                              ${item.reference}
                          </td>
                               <td scope="row"
                              class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white">
                              ${item.from_department}
                          </td>
                               <td scope="row"
                              class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white">
                              ${item.to_department}
                          </td>
                              <td scope="row"
                              class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white">
                              ${item.from_name}
                          </td>
                              <td scope="row"
                              class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white">
                              ${item.to_name}
                          </td>

                      `;
                                                            if(item.status == 1){
                                                                custom += `
                                                                       <td scope="row"
                                                                         class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                                <span
                                                                    class="inline-flex items-center bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
                                                                    <span class="w-2 h-2 me-1 bg-green-500 rounded-full"></span>
                                                                    Active
                                                                </span>
                                                                  </td>`;

                                                            }else if(item.status == 3){
                                                                custom+= `
                                                                   <td scope="row"
                                                                         class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                                      <span
                                                                class="inline-flex items-center bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">
                                                                <span class="w-2 h-2 me-1 bg-red-500 rounded-full"></span>
                                                                Deleted
                                                                </span>
                                                                 </td>
                                                              `;
                                                            }else if(item.status == 0){
                                                                custom += `
                                                                      <td scope="row"
                                                                         class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                                <span
                                                                class="inline-flex items-center bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">
                                                                <span class="w-2 h-2 me-1 bg-red-500 rounded-full"></span>
                                                                Inactive
                                                            </span>
                                                                 </td>`;
                                                            }
                                                            custom+=`
                                                            <td class="px-1 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 bg-gray-100 dark:bg-black  text-gray-900 whitespace-nowrap dark:text-white"
                                                            style="  position: sticky; right: 0; ">
                                                             `;
                                                            if(item.status == 1){
                                                                if(auth.permission.transfer_update == 1 && auth.permission.transfer_read == 0){
                                                                    custom += `<a
                                                                    href="/admin/movement/edit/id=${item.id}/assets_id=${item.assets_id}/varaint=${item.varaint}">
                                                                    <button type="button"
                                                                        class="text-white bg-gradient-to-r scale-50 lg:scale-100  from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"><i
                                                                            class="fa-solid fa-pen-to-square" style="color: #ffffff;"></i>
                                                                    </button>
                                                                </a>`;
                                                                }else if(auth.permission.transfer_update == 0 && auth.permission.transfer_read == 1){
                                                                    custom+=`
                                                                      <a
                                                                    href="/admin/movement/view/id=${item.id}/assets_id=${item.assets_id}/varaint=${item.varaint}">
                                                                    <button type="button"
                                                                        class="text-white scale-50 lg:scale-100 bg-gradient-to-r from-purple-300 via-purple-500 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-500 dark:focus:ring-green-500 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                                                                        <i class="fa-solid  fa-eye" style="color: #ffffff;"></i>
                                                                    </button>
                                                                    </a>
                                                                `;
                                                                }else if(auth.permission.transfer_update == 1 && auth.permission.transfer_read == 1){
                                                                    custom += `
                                                                    <a
                                                                        href="/admin/movement/edit/id=${item.id}/assets_id=${item.assets_id}/varaint=${item.varaint}">
                                                                        <button type="button"
                                                                            class="text-white bg-gradient-to-r scale-50 lg:scale-100  from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"><i
                                                                                class="fa-solid fa-pen-to-square" style="color: #ffffff;"></i>
                                                                        </button>
                                                                        </a>
                                                                    `;
                                                                }
                                                                if(auth.permission.transfer_delete == 1){
                                                                custom += `
                                                                    <button type="button" data-id="${item.id}"
                                                                    id="btn_delete_asset${item.id}"
                                                                    onclick="delete_value('btn_delete_asset'+${item.id},'delete_asset_admin','delete_value_asset')"
                                                                    class="scale-50 lg:scale-100 text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                                                                    <i class="fa-solid fa-trash" style="color: #ffffff;"></i></button>

                                                                `;
                                                                }
                                                            }else{
                                                                    custom += `<a
                                                                href="/admin/movement/view/id=${item.id}/assets_id=${item.assets_id}/varaint=${item.varaint}">
                                                                <button type="button"
                                                                    class="text-white scale-50 lg:scale-100 bg-gradient-to-r from-purple-300 via-purple-500 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-500 dark:focus:ring-green-500 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                                                                    <i class="fa-solid  fa-eye" style="color: #ffffff;"></i>
                                                                </button>
                                                                </a>
                                                                <div style="width: 100%; height: 100%;"> </div>`;
                                                            }



                                                             custom +=  `
                                                                    </td>
                                                                </tr>
                                                            `;
            body_change.innerHTML += custom;
        });
    } else {
        alert("Error No Table body.");
    }
}
function show_sort_user() {
    let body_change = document.querySelector("#user_tb");
    if (body_change) {
        body_change.innerHTML = ``;

        array.map((item) => {
            let custom = ``;
            if (auth.id == item.id) {
                custom += `
                <tr class="bg-green-300 border-b dark:bg-gray-800 dark:border-gray-700">`;
            } else {
                custom += `<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
               `;
            }

            custom += `
                         <td scope="row"
                              class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white">
                              ${item.id}
                          </td>
                         <td scope="row"
                              class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white">
                              ${item.fname + item.lname}
                          </td>
                          <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  ">
                              ${item.email}
                          </td>
                          <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  ">
                                ${item.role}
                          </td>`;
            if (item.status == 0) {
                custom += `
       <td scope="row" class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  ">
                   <span
                                      class="inline-flex items-center bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">
                                      <span class="w-2 h-2 me-1 bg-red-500 rounded-full"></span>
                                      Inactive
                                  </span>
      </td>`;
            } else {
                custom += `
         <td scope="row" class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  ">
                       <span
                                      class="inline-flex items-center bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
                                      <span class="w-2 h-2 me-1 bg-green-500 rounded-full"></span>
                                      Active
                                  </span>
                                                  </td>`;
            }
            custom += `<td scope="row" class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">`;
            if (auth.permission.user_update == 1) {
                custom += `

              <a href="/admin/user/update/id=${item.id}">
                                      <button type="button"
                                          class="scale-50 lg:scale-100 text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"><i
                                              class="fa-solid fa-pen-to-square" style="color: #ffffff;"></i></button>
               </a>
     `;
            }
            if (
                (auth.permission.user_write == 0 &&
                    auth.permission.user_update == 0) ||
                (auth.permission.user_write == 1 &&
                    auth.permission.user_update == 0)
            ) {
                custom += `
                                   <button type="button"
                                      class="scale-50 lg:scale-100 text-white bg-gradient-to-r from-purple-300 via-purple-500 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-500 dark:focus:ring-green-500 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                                      <i class="fa-solid fa-eye" style="color: #ffffff;"></i>
                                  </button>
      `;
            }
            if (auth.permission.user_delete == 1) {
                custom += `
                                  <button type="button" data-id="${item.id}"
                                      onclick="delete_value('btn_delete'+${item.id},'delete_user','delete_value')"
                                      id="btn_delete${item.id}"
                                      class="scale-50 lg:scale-100 text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"><i
                                          class="fa-solid fa-trash" style="color: #ffffff;"></i>

                                  </button>`;
            }
            custom += `</td>`;
            custom += `</tr>`;

            body_change.innerHTML += custom;
        });
    } else {
        alert("Error No Table body.");
    }
}

function show_sort_staff_asset() {
    let body_change = document.querySelector("#asset_staff_body");
    body_change.innerHTML = ``;
    array.map((item) => {
        body_change.innerHTML += `

     <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                     <td class="print_val px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                            <input onchange="printable()" data-id="${
                                                item.id
                                            }" id="green-checkbox"
                                            type="checkbox" value=""
                                        class="select_box w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    </td>
                                    <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                        ${item.id || ""}
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
                                    <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                          ${item.document || ""}
                                    </td>

                                    <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                             ${
                                                 item.assets1 + item.assets2 ||
                                                 ""
                                             }
                                    </td>
                                    <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                ${item.fa || ""}
                                    </td>
                                    <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                 ${item.fa_type || ""}
                                    </td>

                                        <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                               ${
                                   item.status == 0
                                       ? `  <span
                                        class="inline-flex items-center bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
                                        <span class="w-2 h-2 me-1 bg-green-500 rounded-full"></span>
                                        Active
                                    </span>
                                    `
                                       : item.status == 1
                                       ? `
                                       <span
                                      class="inline-flex items-center bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">
                                      <span class="w-2 h-2 me-1 bg-red-500 rounded-full"></span>
                                      Deleted
                                  </span>
                              `
                                       : ` <span
                                    class="inline-flex items-center bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">
                                    <span class="w-2 h-2 me-1 bg-red-500 rounded-full"></span>
                                    Sold
                                </span>`
                               }
                                    </td>
                                    <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                               ${item.fa_class || ""}
                                    </td>
                                    <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                      ${item.fa_subclass || ""}
                                    </td>
                                    <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                           ${item.depreciation || ""}
                                    </td>
                                    <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                       ${item.dr || ""}
                                    </td>
                                    <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                        ${item.pr || ""}
                                    </td>
                                    <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                        ${item.invoice_no || ""}

                                    </td>
                                    <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                         ${item.description || ""}
                                    </td>
                                  <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  dark:bg-slate-900"
                                    style="position: sticky; right: 0; background-color: white;">
                                    ${
                                        (auth?.permission?.assets_read == 1) &
                                        (auth?.permission?.assets_update == 0)
                                            ? `   <button type="button"
                                            class="text-white bg-gradient-to-r from-purple-300 via-purple-500 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-500 dark:focus:ring-green-500 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                                            <i class="fa-solid fa-eye" style="color: #ffffff;"></i>
                                        </button>
                                        `
                                            : ``
                                    }

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
    array.map((item, index) => {
        body_change.innerHTML += `

    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                       <td scope="row"
                            class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            ${item.id??''}
                        </td>
                        <td scope="row"
                            class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                 ${item.content??''}
                        </td>
                        <td scope="row"
                            class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                 ${item.type??''}
                        </td>
                                 <td scope="row"
                                        class=" px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  font-medium text-gray-900 whitespace-nowrap dark:text-white">


                                        <button type="button" data-modal-target="small-modal"
                                            data-modal-toggle="small-modal"
                                            onclick="update_quick_data(${index})"
                                            class="scale-50 lg:scale-100 text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"><i
                                                class="fa-solid fa-pen-to-square" style="color: #ffffff;"></i>
                                        </button>
                                        <!-- Modal toggle -->
                        <button type="button" data-id="${item.id}"
                            id="btn_delete${item.id}"
                                onclick="delete_value('btn_delete'+${item.id},'delete_data','delete_data_value')"
                            class="scale-50 lg:scale-100 text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
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
}
function isObject(data) {
    return data !== null && typeof data === "object";
}

function show_sort_asset() {
    let body_change = document.querySelector("#assets_body");
    body_change.innerHTML = ``;
    array.map((item) => {
        let custom = ``;
        custom += `

        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">

                                <td class="print_val px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                    <input onchange="printable()" data-id="${
                                        item.id || ""
                                    }" id="green-checkbox"
                                        type="checkbox" value=""
                                        class="select_box w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                </td>
                                    <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                        ${item.id || ""}
                                    </td>
                                    <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                   ${
                                       item.issue_date
                                           ? new Date(
                                                 item.issue_date
                                             ).toLocaleDateString("en-US", {
                                                 year: "numeric",
                                                 month: "short",
                                                 day: "numeric",
                                             })
                                           : ""
                                   }

                                    </td>
                                    <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                          ${item.document || ""}
                                    </td>

                                    <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                            ${item.assets1 || ""}${item.assets2 || ""}
                                    </td>

                                     <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                            ${item.item||""}
                                    </td>
                                         <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                            ${item.specification||""}
                                    </td>
                                        </td>
                                         <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                            ${item.initial_condition||""}
                                    </td>
                                    <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                ${item.fa || ""}
                                    </td>
                                    <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                 ${item.fa_type || ""}
                                    </td>

                                        <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                               ${
                                   item.status == 0
                                       ? `  <span
                                        class="inline-flex items-center bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
                                        <span class="w-2 h-2 me-1 bg-green-500 rounded-full"></span>
                                        Active
                                    </span>
                                    `
                                       : item.status == 1
                                       ? `
                                       <span
                                      class="inline-flex items-center bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">
                                      <span class="w-2 h-2 me-1 bg-red-500 rounded-full"></span>
                                      Deleted
                                  </span>
                              `
                                       : ` <span
                                    class="inline-flex items-center bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">
                                    <span class="w-2 h-2 me-1 bg-red-500 rounded-full"></span>
                                    Sold
                                </span>`
                               }
                                    </td>
                                    <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                               ${item.fa_class || ""}
                                    </td>
                                    <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                      ${item.fa_subclass || ""}
                                    </td>
                                    <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                           ${item.depreciation || ""}
                                    </td>
                                    <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                       ${item.dr || ""}
                                    </td>
                                    <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                        ${item.pr || ""}
                                    </td>
                                    <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                        ${item.invoice_no || ""}

                                    </td>
                                    <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                         ${item.description || ""}
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

                                     <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  dark:bg-slate-900"
                                    style="position: sticky; right: 0; background-color: white;">
                                    `;
                                    if(auth?.permission?.assets_read == 1 && auth?.permission?.assets_update == 0){

                                                 custom+=`
                                                 <a href="/admin/assets/view/id=${item.id}">
                                                 <button type="button"
                                                class="text-white scale-50 lg:scale-100 bg-gradient-to-r from-purple-300 via-purple-500 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-500 dark:focus:ring-green-500 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                                                <i class="fa-solid  fa-eye" style="color: #ffffff;"></i>
                                                </button>
                                                </a>`;
                                    }else if(auth?.permission?.assets_read == 0 && auth?.permission?.assets_update == 1){
                                        custom+= ` <a href="/admin/assets/edit/id=${item.id}">
                                        <button type="button"
                                            class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"><i
                                                class="fa-solid fa-pen-to-square" style="color: #ffffff;"></i>
                                        </button>
                                     </a>`;
                                    }else if(auth?.permission?.assets_read == 1 && auth?.permission?.assets_update == 1){
                                        custom+= ` <a href="/admin/assets/edit/id=${item.id}">
                                        <button type="button"
                                            class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"><i
                                                class="fa-solid fa-pen-to-square" style="color: #ffffff;"></i>
                                        </button>
                                     </a>`;

                                    }
                                    if(auth?.permission?.assets_delete == 1){
                                        custom+= `
                                        <button type="button" data-id="${item.id}"
                                        id="btn_delete_asset${item.id}"
                                        onclick="delete_value('btn_delete_asset'+${item.id},'delete_asset_admin','delete_value_asset')"
                                        class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                                        <i class="fa-solid fa-trash" style="color: #ffffff;"></i></button>
                                        `;
                                    }

                                    custom+= `</td></tr>`;


                                    body_change.innerHTML+= custom;
    });
}
function show_sort_raw_asset() {
    let body_change = document.querySelector("#table_raw_body");
    body_change.innerHTML = ``;
    array.map((item, index) => {
        body_change.innerHTML += `

            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">

                                            <td scope="row"
                                                class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                ${index + 1}
                                            </td>
                                            <td scope="row"
                                                class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  font-medium text-gray-900 whitespace-nowrap dark:text-white">


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
                                                class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                ${item.assets}
                                            </td>
                                            <td scope="row"
                                                class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                ${item.fa || ""}
                                            </td>

                                            <td scope="row"
                                                class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                ${item.invoice_no}
                                            </td>
                                            <td scope="row"
                                                class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                ${item.description}
                                            </td>


                                            <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                                <a href="/admin/assets/add/assets=${
                                                    item.assets
                                                }/invoice_no=${
                                                    item.fa ? item.fa.replace(/\//g, "-") : "NA"}"
                                                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Select</a>
                                            </td>

                                        </tr>

            `;
    });
}
function close_modal(){
    document.querySelector("#small-modal").style.display = "none";
}
function update_quick_data(item) {
    document.querySelector("#small-modal").style.display = "block";

    let content = document.querySelector("#content_update");
    let type = document.querySelector("#type_update");
    let id = document.querySelector("#id_update");
    let reference = document.querySelector("#reference_update");
    let span_reference = document.querySelector("#span_reference");
    if (isObject(item) == true) {
        if (content) {
            content.value = item.content;
        }
        if (type) {
            type.value = item.type;
        }
        if (id) {
            id.value = item.id;
        }

    } else {

        if (content) {
            content.value = array[item].content;
        }
        if (type) {
            type.value = array[item].type;
        }
        if (id) {
            id.value = array[item].id;
        }
        if(array[item].type == 'Employee'){
            reference.value = array[item].reference;
            reference.style.display = 'block';
            span_reference.style.display = 'block';
        }else{
            reference.style.display = 'none';
            span_reference.style.display= 'none';
        }
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

function export_group() {
    let li_print = document.querySelectorAll(".print_val");
    let li_print_array = Array.from(li_print);
    let id_for_export = [];
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
    let fa = document.querySelector("#fa");
    let asset_input = document.querySelector("#assets");
    let invoice = document.querySelector("#invoice");
    let description = document.querySelector("#description");
    let start = document.querySelector("#start_date");
    let end = document.querySelector("#end_date");
    let state = document.querySelector("#state");
    let id_asset = document.querySelector("#id_asset");
    let other = document.querySelector("#other_search");
    let value = document.querySelector("#other_value");

    let id_val = "NA";
    let fa_val = "NA";
    let asset_val = "NA";
    let invoice_val = "NA";
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
    if (id_asset) {
        if (id_asset.value != "") {
            id_val = id_asset.value;
        }
    }
    if (fa) {
        if (fa.value != "") {
            fa_val = fa.value;
        }
    }
    if (asset_input) {
        if (asset_input.value != "") {
            asset_val = asset_input.value;
        }
    }
    if (invoice) {
        if (invoice.value != "") {
            invoice_val = invoice.value;
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
    url = `/api/fect/asset/data`;
    // Loading label
    document.querySelector("#loading").style.display = "block";

    let data = await fetch(url, {
        method: "POST",
        headers: {
            Authorization: `Bearer ${token}`,
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            type: type_val,
            value: value_val,
            id: id_val,
            state: state_val,
            asset: asset_val,
            fa: fa_val,
            invoice: invoice_val,
            end: end_val,
            start: start_val,
            description: description_val,
            page: page,
        }),
    })
        .then((res) => res.json())
        .catch((error) => {
            alert(error);
        });

    if (data) {
        console.log(data);
        if (data.data) {

            if (data.data.length > 0) {
                let pagination_search = document.querySelector(
                    ".pagination_by_search"
                );
                if (pagination_search) {
                    pagination_search.style.display = "block";

                    if (data.page != 0) {
                        let page = data.page;
                        let totalPage = data.total_page;
                        let totalRecord = data.total_record;
                        console.log(data);
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
                                    <a href="1" aria-current="page"
                                        class="z-10 flex items-center justify-center px-1 h-4   lg:px-3 lg:h-8  md:px-1 md:h-4 leading-tight text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">
                                        <i class="fa-solid fa-filter-circle-xmark" style="color: #ff0000;"></i>
                                    </a>
                                </li>
                                </ul>
                        <select
                            onchange="set_page_dynamic_admin()"
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
                                        &ensp;Total Assets: ${totalRecord} Records</span>


                                 </div>
                                 `;

                        // Finally, assign the full HTML to the element
                        pagination_search.innerHTML = paginationHtml;
                    }
                }

                let body_change = document.querySelector("#assets_body");
                body_change.innerHTML = ``;
                data.data.map((item) => {
                    let custom = ``;
                    custom += `

                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">

                                            <td class="print_val px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                                <input onchange="printable()" data-id="${
                                                    item.assets_id || ""
                                                }" id="green-checkbox"
                                                    type="checkbox" value=""
                                                    class="select_box w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            </td>
                                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                                    ${item.assets_id || ""}
                                                </td>
                                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                               ${
                                                   item.issue_date
                                                       ? new Date(
                                                             item.issue_date
                                                         ).toLocaleDateString("en-US", {
                                                             year: "numeric",
                                                             month: "short",
                                                             day: "numeric",
                                                         })
                                                       : ""
                                               }

                                                </td>
                                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                                      ${item.document || ""}
                                                </td>

                                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                                ${item.assets1 || ""}${item.assets2 || ""}
                                                </td>
                                                        <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                            ${item.item||""}
                                    </td>
                                         <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                            ${item.specification||""}
                                    </td>
                                        </td>
                                         <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                            ${item.initial_condition||""}
                                    </td>
                                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                            ${item.fa || ""}
                                                </td>
                                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                             ${item.fa_type || ""}
                                                </td>

                                                    <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                           ${
                                               item.status == 0
                                                   ? `  <span
                                                    class="inline-flex items-center bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
                                                    <span class="w-2 h-2 me-1 bg-green-500 rounded-full"></span>
                                                    Active
                                                </span>
                                                `
                                                   : item.status == 1
                                                   ? `
                                                   <span
                                                  class="inline-flex items-center bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">
                                                  <span class="w-2 h-2 me-1 bg-red-500 rounded-full"></span>
                                                  Deleted
                                              </span>
                                          `
                                                   : ` <span
                                                class="inline-flex items-center bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">
                                                <span class="w-2 h-2 me-1 bg-red-500 rounded-full"></span>
                                                Sold
                                            </span>`
                                           }
                                                </td>
                                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                           ${item.fa_class || ""}
                                                </td>
                                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                                  ${item.fa_subclass || ""}
                                                </td>
                                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                                       ${item.depreciation || ""}
                                                </td>
                                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                                   ${item.dr || ""}
                                                </td>
                                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                                    ${item.pr || ""}
                                                </td>
                                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                                    ${item.invoice_no || ""}

                                                </td>
                                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                                     ${item.description || ""}
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
                                                 <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  dark:bg-slate-900"
                                                style="position: sticky; right: 0; background-color: white;">
                                                `;
                                                if(auth?.permission?.assets_read == 1 && auth?.permission?.assets_update == 0){

                                                             custom+=`
                                                             <a href="/admin/assets/view/id=${item.assets_id}">
                                                             <button type="button"
                                                            class="text-white scale-50 lg:scale-100 bg-gradient-to-r from-purple-300 via-purple-500 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-500 dark:focus:ring-green-500 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                                                            <i class="fa-solid  fa-eye" style="color: #ffffff;"></i>
                                                            </button>
                                                            </a>`;
                                                }else if(auth?.permission?.assets_read == 0 && auth?.permission?.assets_update == 1){
                                                    custom+= ` <a href="/admin/assets/edit/id=${item.assets_id}">
                                                    <button type="button"
                                                        class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"><i
                                                            class="fa-solid fa-pen-to-square" style="color: #ffffff;"></i>
                                                    </button>
                                                 </a>`;
                                                }else if(auth?.permission?.assets_read == 1 && auth?.permission?.assets_update == 1){
                                                    custom+= ` <a href="/admin/assets/edit/id=${item.assets_id}">
                                                    <button type="button"
                                                        class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"><i
                                                            class="fa-solid fa-pen-to-square" style="color: #ffffff;"></i>
                                                    </button>
                                                 </a>`;

                                                }
                                                if(auth?.permission?.assets_delete == 1){
                                                    custom+= `
                                                    <button type="button" data-id="${item.assets_id}"
                                                    id="btn_delete_asset${item.assets_id}"
                                                    onclick="delete_value('btn_delete_asset'+${item.assets_id},'delete_asset_admin','delete_value_asset')"
                                                    class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                                                    <i class="fa-solid fa-trash" style="color: #ffffff;"></i></button>
                                                    `;
                                                }

                                                custom+= `</td></tr>`;


                                                body_change.innerHTML+= custom;
                });
                array = data.data;
            } else {
                alert("Data not Found.");
            }
        } else {
            alert("Data not Found.");
        }
    } else {
        alert("Problem on database connection.");
    }
    document.querySelector("#loading").style.display = "none";
}
async function search_asset_staff(no) {
    let fa = document.querySelector("#fa");
    let asset_input = document.querySelector("#assets");
    let invoice = document.querySelector("#invoice");
    let description = document.querySelector("#description");
    let start = document.querySelector("#start_date");
    let end = document.querySelector("#end_date");
    let state = document.querySelector("#state");
    let id_asset = document.querySelector("#id_asset");
    let other = document.querySelector("#other_search");
    let value = document.querySelector("#other_value");

    let id_val = "NA";
    let fa_val = "NA";
    let asset_val = "NA";
    let invoice_val = "NA";
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
    if (id_asset) {
        if (id_asset.value != "") {
            id_val = id_asset.value;
        }
    }
    if (fa) {
        if (fa.value != "") {
            fa_val = fa.value;
        }
    }
    if (asset_input) {
        if (asset_input.value != "") {
            asset_val = asset_input.value;
        }
    }
    if (invoice) {
        if (invoice.value != "") {
            invoice_val = invoice.value;
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
    url = `/api/fect/asset/staff/data`;

    // Loading label
    document.querySelector("#loading").style.display = "block";

    let form = document.querySelector("#form_search");
    if (form) {
        if (!form.checkValidity()) {
            // Trigger native form validation messages without submitting
            form.reportValidity();
        }
    }

    // console.log("type: "+ type_val+"    value "+value_val+"    "+id_val+"    "+state_val+"    "+start_val+"    "+end_val+"    "+description_val+"    page"+page+"    "+invoice_val+"    "+fa_val+"    ")
    let data = await fetch(url, {
        method: "POST",
        headers: {
            Authorization: `Bearer ${token}`,
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            type: type_val,
            value: value_val,
            id: id_val,
            state: state_val,
            asset: asset_val,
            fa: fa_val,
            invoice: invoice_val,
            end: end_val,
            start: start_val,
            description: description_val,
            page: page,
        }),
    })
        .then((res) => res.json())
        .catch((error) => {
            alert(error);
        });

    if (data) {
        if (data.data) {
            if (data.data.length > 0) {
                let pagination_search = document.querySelector(
                    ".pagination_by_search"
                );
                if (pagination_search) {
                    pagination_search.style.display = "block";

                    if (data.page != 0) {
                        let page = data.page;
                        let totalPage = data.total_page;
                        // Start by building the entire HTML content in one go
                        let paginationHtml = `
                            <div class="flex">
                                <ul class="flex items-center -space-x-px h-8 text-sm">

                                `;

                        let left_val = page - 5;
                        // Prevent < 0
                        if (left_val < 1) {
                            left_val = 1;
                        }
                        // Left Arrow
                        if (page != 1 && totalPage != 1) {
                            paginationHtml += `
                                    <li onclick="search_asset_staff(${
                                        page - 1
                                    })"  class="flex items-center justify-center px-1 h-4   lg:px-3 lg:h-8  md:px-1 md:h-4 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">


                                            <i class="fa-solid fa-angle-left"></i>

                                    </li>
                                 `;
                        }

                        let right_val = page + 5;

                        // Prevent < total
                        if (right_val > totalPage) {
                            right_val = totalPage;
                        }

                        // For on left and right Value

                        for (let i = left_val; i <= right_val; i++) {
                            if (i != page) {
                                paginationHtml += `
                                        <li onclick="search_asset_staff(${i})" class="flex items-center justify-center px-1 h-4   lg:px-3 lg:h-8  md:px-1 md:h-4 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                                        >

                                                 ${i}

                                         </li>
                                     `;
                            } else if (i == page) {
                                paginationHtml += `
                                          <li onclick="search_asset_staff(${i})" class="z-10 flex items-center justify-center px-1 h-4   lg:px-3 lg:h-8  md:px-1 md:h-4 leading-tight text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">

                                                ${i}

                                        </li>
                                     `;
                            }
                        }

                        if (page != totalPage) {
                            paginationHtml += `
                                    <li  onclick="search_asset_staff(${
                                        page + 1
                                    })" class="flex items-center justify-center px-1 h-4   lg:px-3 lg:h-8  md:px-1 md:h-4 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">


                                            <i class="fa-solid fa-chevron-right"></i>

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
                                 <select
                                    onchange="set_page_dynamic()"
                                    id="select_page_dynamic"
                                    class="flex mx-2 items-center justify-center px-1 h-4   lg:px-3 lg:h-8  md:px-1 md:h-4 text-sm leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
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
                                </div>
                                `;

                        // Finally, assign the full HTML to the element
                        pagination_search.innerHTML = paginationHtml;
                    }
                }

                let body_change = document.querySelector("#asset_staff_body");
                body_change.innerHTML = ``;
                data.data.map((item) => {
                    body_change.innerHTML += `

                 <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">

                                            <td class="print_val px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                                <input onchange="printable()" data-id="${
                                                    item.id || ""
                                                }" id="green-checkbox"
                                                    type="checkbox" value=""
                                                    class="select_box w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            </td>
                                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                                    ${item.id || ""}
                                                </td>
                                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                               ${
                                                   item.created_at
                                                       ? new Date(
                                                             item.created_at
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
                                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                                      ${item.document || ""}
                                                </td>

                                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                                         ${
                                                             item.assets1 +
                                                                 item.assets2 ||
                                                             ""
                                                         }
                                                </td>
                                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                            ${item.fa || ""}
                                                </td>
                                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                             ${item.fa_type || ""}
                                                </td>

                                                    <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                           ${
                                               item.status == 0
                                                   ? `  <span
                                                    class="inline-flex items-center bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
                                                    <span class="w-2 h-2 me-1 bg-green-500 rounded-full"></span>
                                                    Active
                                                </span>
                                                `
                                                   : item.status == 1
                                                   ? `
                                                   <span
                                                  class="inline-flex items-center bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">
                                                  <span class="w-2 h-2 me-1 bg-red-500 rounded-full"></span>
                                                  Deleted
                                              </span>
                                          `
                                                   : ` <span
                                                class="inline-flex items-center bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">
                                                <span class="w-2 h-2 me-1 bg-red-500 rounded-full"></span>
                                                Sold
                                            </span>`
                                           }
                                                </td>
                                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                           ${item.fa_class || ""}
                                                </td>
                                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                                  ${item.fa_subclass || ""}
                                                </td>
                                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                                       ${
                                                           item.depreciation ||
                                                           ""
                                                       }
                                                </td>
                                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                                   ${item.dr || ""}
                                                </td>
                                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                                    ${item.pr || ""}
                                                </td>
                                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                                    ${item.invoice_no || ""}

                                                </td>
                                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                                     ${item.description || ""}
                                                </td>
                                              <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  dark:bg-slate-900"
                                                style="position: sticky; right: 0; background-color: white;">
                                                ${
                                                    auth?.permission
                                                        ?.assets_write == 1
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
                                                    auth?.permission
                                                        ?.assets_delete == 1
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
                array = data.data;

                document.querySelector("#loading").style.display = "none";
            } else {
                alert("Data not Found.");
                document.querySelector("#loading").style.display = "none";
            }
        } else {
            alert("Data not array");
            document.querySelector("#loading").style.display = "none";
        }
    } else {
        alert("Problem on database connection.");

        document.querySelector("#loading").style.display = "none";
    }
}

function set_page_dynamic() {
    let select = document.querySelector("#select_page_dynamic");
    if (select) {
        if (select.value != "") {
            search_asset_staff(parseInt(select.value));
        }
    }
}
function set_page_dynamic_admin() {
    let select = document.querySelector("#select_page_dynamic");
    if (select) {
        if (select.value != "") {
            search_asset(parseInt(select.value));
        }
    }
}
function select_page_dynamic_select_movement(){
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
    let select = document.querySelector("#select_page_dynamic_select_movement");
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
    document.querySelector("#loading").style.display = "block";
    let url = `/api/raw/assets`;

    let data = await fetch(url, {
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
    let body_table = document.querySelector("#table_raw_body");

    if (data) {
        console.log(data);
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
                .map(
                    (item, index) => `
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td scope="row"
                            class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            ${index + 1}
                        </td>
                        <td scope="row"
                            class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  font-medium text-gray-900 whitespace-nowrap dark:text-white">
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
                            class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  font-medium text-gray-900 whitespace-nowrap dark:text-white">
                           ${item.assets}
                        </td>
                        <td scope="row"
                            class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            ${item.fa}
                        </td>
                        <td scope="row"
                            class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            ${item.invoice_no}
                        </td>
                        <td scope="row"
                            class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            ${item.description}
                        </td>
                         <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                            <a href="/admin/assets/add/assets=${
                                item.assets
                            }/invoice_no=${item.fa ? item.fa.replace(/\//g, '-') : "NA"}"
                                class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Select</a>
                        </td>

                    </tr>
                `
                )
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
                            <span class="font-bold flex justify-left items-center text-gray-900 dark:text-white">Page :${totalPage} Pages  &ensp;Total Assets: ${totalRecord} Records</span>

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

            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
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
                document.querySelector("#loading").style.display = "none";
            }
        } else {
            alert("Data not found");
            document.querySelector("#loading").style.display = "none";
        }
    } else {
        alert("Error Fetch not responce");
        document.querySelector("#loading").style.display = "none";
    }
}
function set_page() {
    let select_page = document.querySelector("#select_page");

    if (select_page) {
        if (select_page.value != "") {
            window.location.href = `/admin/assets/list/${select_page.value}`;
        }
    }
}
function set_page_movement() {
    let select_page = document.querySelector("#select_page");

    if (select_page) {
        if (select_page.value != "") {
            window.location.href = `/admin/movement/add/${select_page.value}`;
        }
    }
}
function set_page_movement_search() {
    let select_page = document.querySelector("#select_page");

    if (select_page) {
        if (select_page.value != "") {
            window.location.href = `/admin/movement/list/${select_page.value}`;
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
function set_page_quick_data() {
    let select_page = document.querySelector("#select_page");

    if (select_page) {
        if (select_page.value != "") {
            window.location.href = `/quick/data/${select_page.value}`;
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
async function search_quick_data(no) {
    let type = document.querySelector("#type_search");
    let content = document.querySelector("#content_search");

    let type_val = "NA";
    let content_val = "NA";

    if (type) {
        if (type.value != "") {
            type_val = type.value;
        }
    }
    if (content) {
        if (content.value != "") {
            content_val = content.value;
        }
    }

    let page = 1;
    if (no != 0) {
        page = no;
    }

    // Loading label
    document.querySelector("#loading").style.display = "block";
    let url = `/api/quick/data/search`;
    let data = await fetch(url, {
        method: "POST",
        headers: {
            Authorization: `Bearer ${token}`,
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            type: type_val,
            content: content_val,
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
            if (data.data.length > 0) {
                let page = data.page;
                let totalPage = data.total_page;
                let totalRecord = data.total_record ?? 0;
                let total_label = document.querySelector("#total_state");
                if (totalRecord) {
                    total_label.innerHTML = `
                       <span class="font-bold flex justify-left items-center text-gray-900 dark:text-white">Found: ${totalPage} Pages
                                    &ensp; ${totalRecord} Records</span>
                 `;
                }

                let pagination_search = document.querySelector(
                    ".pagination_by_search"
                );

                if (pagination_search) {
                    if (totalRecord > 150) {
                        pagination_search.style.display = "block";
                        //   Start by building the entire HTML content in one go
                        let paginationHtml = `
                             <div class="flex">
                                 <ul class="flex items-center -space-x-px h-8 text-sm">

                                 `;

                        //   Add the current page dynamically
                        let left_val = page - 5;
                        if (left_val < 1) {
                            left_val = 1;
                        }
                        if (page != 1 && totalPage != 1) {
                            paginationHtml += `
                                     <li onclick="search_quick_data(${
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
                        let state_i = 0;
                        for (let i = left_val; i <= right_val; i++) {
                            if (i != page) {
                                paginationHtml += `
                                         <li onclick="search_quick_data(${i})" class="flex items-center justify-center px-1 h-4   lg:px-3 lg:h-8  md:px-1 md:h-4 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                                         >

                                                  ${i}


                                          </li>
                                      `;
                                state_i = i;
                            } else if (i == page) {
                                paginationHtml += `
                                           <li onclick="search_quick_data(${i})" class="z-10 flex items-center justify-center px-1 h-4   lg:px-3 lg:h-8  md:px-1 md:h-4 leading-tight text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">
                                           ${i}
                                         </li>
                                      `;
                                state_i = i;
                            }
                        }

                        if (state_i != totalPage) {
                            paginationHtml += `
                             <li onclick="search_quick_data(${totalPage})" class="flex items-center justify-center px-1 h-4   lg:px-3 lg:h-8  md:px-1 md:h-4 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                        >

                                ${totalPage}


                     </li>`;
                        }
                        if (page != totalPage) {
                            paginationHtml += `
                                     <li onclick="search_quick_data(${
                                         page + 1
                                     })" class="flex items-center justify-center px-1 h-4   lg:px-3 lg:h-8  md:px-1 md:h-4 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                             <i class="fa-solid fa-chevron-right"></i>

                                     </li>
                                         `;
                        }

                        //   Add the remaining pagination buttons and close the list
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
                                 <select  onchange="set_page_dynamic_quick()" id="select_page_dynamic_quick"  class="flex mx-2 items-center justify-center px-1 h-4   lg:px-3 lg:h-8  md:px-1 md:h-4 text-sm leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"  name="" id="">
                                 <option value="${page}">${page}</option>
                                 `;

                        for (i = 1; i <= totalPage; i++) {
                            paginationHtml += `<option value="${i}">${i}</option>`;
                        }

                        paginationHtml += `
                                 </select>
                            </div>
                              `;

                        //   Finally, assign the full HTML to the element
                        pagination_search.innerHTML = paginationHtml;
                    } else {
                        pagination_search.innerHTML = ``;
                        pagination_search.style.display = "block";
                    }
                }

                let body_change = document.querySelector("#body_quick_data");
                body_change.innerHTML = ``;

                data.data.map((item, index) => {
                    body_change.innerHTML += `

                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                               <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                    ${item.id}
                               </td>
                               <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                    ${item.content}
                               </td>
                                 <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                    ${item.type}
                               </td>
                                      <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                    ${item.reference??''}
                               </td>
                                <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 ">
                                     <button type="button" data-modal-target="small-modal"
                                            data-modal-toggle="small-modal"
                                            onclick="update_quick_data(${index})"
                                            class="scale-50 lg:scale-100 text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"><i
                                                class="fa-solid fa-pen-to-square" style="color: #ffffff;"></i>
                                        </button>
                                        <!-- Modal toggle -->


                                        <button type="button" data-id="{{ $item->id }}"
                                            id="btn_delete{{ $item->id }}"
                                            onclick="delete_value('btn_delete'+${item.id},'delete_data','delete_data_value')"
                                            class="scale-50 lg:scale-100 text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                                            <i class="fa-solid fa-trash" style="color: #ffffff;"></i></button>
                               </td>
                           </tr>
          `;
                });
                array = data.data;
            } else {
                alert("Data not found");
            }
        } else {
            alert("Data not found");
        }
        document.querySelector("#loading").style.display = "none";
    } else {
        alert("Error Fetch not responce");
        document.querySelector("#loading").style.display = "none";
    }
}

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
        console.log(data);
        console.log(data.data);
        if (data.data) {
            if (data.data.length != 0) {
                panel_list.innerHTML = ``;
                let custom = `
                      <table id="list_assets"
                            class="table_respond max-w-full  text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                              <tr>
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
                        <tr class=" bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  ">
                                                <button>View</button>
                                             </td>
                                             <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  ">
                                                ${item.assets1 + item.assets2}
                                             </td>
                                             <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  ">
                                                ${item.invoice_no}
                                             </td>
                                                    <td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  ">
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
            panel_list.innerHTML = `<h1>No Data Found.</h1>`;
            panel_list.style.display = "block";
        }
    } else {
        panel_list.innerHTML = ``;
        panel_list.innerHTML = `<h1>Problem Data rendering</h1>`;
        panel_list.style.display = "block";
    }
}

async function search_asset_for_movement(no) {
    let fa = document.querySelector("#fa");
    let asset_input = document.querySelector("#assets");
    let invoice = document.querySelector("#invoice");
    let description = document.querySelector("#description");
    let start = document.querySelector("#start_date");
    let end = document.querySelector("#end_date");
    let state = document.querySelector("#state");
    let id_asset = document.querySelector("#id_asset");
    let other = document.querySelector("#other_search");
    let value = document.querySelector("#other_value");
    let status = document.querySelector("#status");

    let status_val = "NA";
    let id_val = "NA";
    let fa_val = "NA";
    let asset_val = "NA";
    let invoice_val = "NA";
    let description_val = "NA";
    let start_val = "NA";
    let end_val = "NA";
    let state_val = "NA";
    let type_val = "NA";
    let value_val = "NA";

    let page = 1;
    if(status){
        status_val = status.value;
    }
    if (no) {
        page = no;
    }
    if (id_asset) {
        if (id_asset.value != "") {
            id_val = id_asset.value;
        }
    }
    if (fa) {
        if (fa.value != "") {
            fa_val = fa.value;
        }
    }
    if (asset_input) {
        if (asset_input.value != "") {
            asset_val = asset_input.value;
        }
    }
    if (invoice) {
        if (invoice.value != "") {
            invoice_val = invoice.value;
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
    // Loading label
    document.querySelector("#loading").style.display = "block";

    let data = await fetch(url, {
        method: "POST",
        headers: {
            Authorization: `Bearer ${token}`,
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            type: type_val,
            value: value_val,
            id: id_val,
            state: state_val,
            asset: asset_val,
            fa: fa_val,
            invoice: invoice_val,
            end: end_val,
            start: start_val,
            description: description_val,
            page: page,
            role:auth.role,
            status: status_val
        }),
    })
        .then((res) => res.json())
        .catch((error) => {
            alert(error);
        });

    if (data) {
        console.log(data);

        if (data.data) {
            if (data.data.length > 0) {
                let pagination_search = document.querySelector(
                    ".pagination_by_search"
                );
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
                                    <li onclick="search_asset_for_movement(${
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
                                        <li onclick="search_asset_for_movement(${i})" class="flex items-center justify-center px-1 h-4   lg:px-3 lg:h-8  md:px-1 md:h-4 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                                        >

                                                 ${i}


                                         </li>
                                     `;
                            } else if (i == page) {
                                paginationHtml += `
                                          <li onclick="search_asset_for_movement(${i})" class="z-10 flex items-center justify-center px-1 h-4   lg:px-3 lg:h-8  md:px-1 md:h-4 leading-tight text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">

                                                ${i}

                                        </li>
                                     `;
                            }
                        }

                        if (page != totalPage) {
                            paginationHtml += `
                                    <li  onclick="search_asset_for_movement(${
                                        page + 1
                                    })" class="flex items-center justify-center px-1 h-4   lg:px-3 lg:h-8  md:px-1 md:h-4 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">


                                            <i class="fa-solid fa-chevron-right"></i>

                                    </li>
                    `;
                        }

                        paginationHtml += `
                           <li class="mx-2" style="margin-left:10px;">
                                    <a href="1" aria-current="page"
                                        class="z-10 flex items-center justify-center px-1 h-4   lg:px-3 lg:h-8  md:px-1 md:h-4 leading-tight text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">
                                        <i class="fa-solid fa-filter-circle-xmark" style="color: #ff0000;"></i>
                                    </a>
                                </li>
                                </ul>
                        <select
                            onchange="set_page_dynamic_admin_movement()"
                            id="select_page_dynamic_select_movement"
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
                                        &ensp;Total Assets: ${totalRecord} Records</span>


                                 </div>
                                 `;

                        // Finally, assign the full HTML to the element
                        pagination_search.innerHTML = paginationHtml;
                    }
                }

                let body_change = document.querySelector("#table_select_movement_body");
                body_change.innerHTML = ``;

                        data.data.map((item) => {
                                let custom = ``;
                                custom += `
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <td scope="row"
                                                class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                ${ item.assets_id }
                                            </td>
                                            <td scope="row"
                                                class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white">

                                                            ${
                                                            item.created_at
                                                                ? new Date(
                                                                        item.created_at
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
                                                class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                ${ item.document }
                                            </td>
                                            <td scope="row"
                                                class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                ${ item.assets1 + item.assets2 }
                                            </td>
                                            <td scope="row"
                                                class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                ${ item.fa }
                                            </td>

                                            <td scope="row"
                                                class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            ${ item.invoice_no }
                                            </td>
                                `;
                                custom += `<td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  ">`;
                                if(item.status == 0){
                                     custom += `     <span
                                            class="inline-flex items-center bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
                                            <span class="w-2 h-2 me-1 bg-green-500 rounded-full"></span>
                                            Active
                                        </span>`;
                                }else if(item.status == 1){
                                    custom += ` <span
                                            class="inline-flex items-center bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">
                                            <span class="w-2 h-2 me-1 bg-red-500 rounded-full"></span>
                                            Deleted
                                        </span>`;
                                }else if(item.status == 2){
                                    custom += `
                                     <span
                                            class="inline-flex items-center bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">
                                            <span class="w-2 h-2 me-1 bg-red-500 rounded-full"></span>
                                            Sold
                                        </span>
                                `;

                                }
                                custom+= ` </td>`;
                               custom += `
                                <td scope="row"
                                    class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    ${ item.item_description }
                                </td>

                                <td scope="row"
                                    class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    ${ item.invoice_description }
                                </td>
                                <td scope="row"
                                    class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    ${ item.total_movement }
                                </td>
                                <td class="px-1 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 bg-gray-100 dark:bg-black  text-gray-900 whitespace-nowrap dark:text-white"
                                style="  position: sticky; right: 0; ">

                                    <a href="/admin/movement/add/detail/id=${ item.assets_id }"
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Create Movement</a>
                                </td>
                            </tr>
                    `;
                    body_change.innerHTML += custom;
                });
                array = data.data;
            } else {
                alert("Data not Found.");
            }
        } else {
            alert("Data not Found.");
        }
    } else {
        alert("Problem on database connection.");
    }
    document.querySelector("#loading").style.display = "none";
}

async function search_movement(no){

    no??1;

    let id = document.querySelector("#id_movement");
    let movement_no = document.querySelector("#movement_no");
    let assets = document.querySelector("#assets");
    let status = document.querySelector("#status");
    let from_department = document.querySelector("#from_department");
    let to_department = document.querySelector("#to_department");
    let start_date = document.querySelector("#from_date");
    let end_date = document.querySelector("#end_date");
    let other_search_input = document.querySelector("#other_search");
    let other_value = document.querySelector("#other_value")



    // Initailize Variable
    let id_val = 'NA';
    let movement_no_val = 'NA';
    let assets_val = 'NA';
    let status_val = 'NA';
    let from_department_val = 'NA';
    let to_department_val = 'NA';
    let start_date_val = 'NA';
    let end_date_val ='NA';
    let other_search_val = 'NA';
    let other_value_val = 'NA';

    if(id){
        if(id.value){
            id_val = id.value;
        }
    }

    if(movement_no){
        if(movement_no.value){
            movement_no_val = movement_no.value;
        }
    }
    if(assets){
        if(assets.value){
            assets_val = assets.value;
        }
    }
    if(status){
        if(status.value){
            status_val = status.value;
        }
    }
    if(from_department){
        if(from_department.value){
            from_department_val = from_department.value;
        }
    }
    if(to_department){
        if(to_department.value){
            to_department_val = to_department.value;
        }
    }

    if(start_date){
        if(start_date.value){
            start_date_val = start_date.value;
        }
    }
    if(end_date){
        if(end_date.value){
            end_date_val = end_date.value;
        }
    }
    if(other_search == 1){
        if(other_search_input){
            if(other_search_input.value){
                other_search_val = other_search_input.value;
            }
        }
        if(other_value){
            if(other_value.value){
                other_value_val = other_value.value;
            }
        }
    }

    if (start_date_val && end_date_val && start_date_val != "NA" && end_date_val != "NA") {
        if (start_date_val > end_date_val) {
            alert(
                "Start Date is greater than End Date.Please select correct date and Try again."
            );
            return;
        }
    }

    document.querySelector("#loading").style.display = "block";

    let url = `/api/fect/search/movement/data`;

    let data = await fetch(url, {
        method: "POST",
        headers: {
            Authorization: `Bearer ${token}`,
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            movement_id : id_val,
            movement_no : movement_no_val,
            assets : assets_val,
            status: status_val,
            from_department : from_department_val,
            to_department : to_department_val,
            start_date : start_date_val,
            end_date : end_date_val,
            other_search : other_search_val,
            other_value : other_value_val,
            page : no
        }),
        })
        .then((res) => res.json())
        .catch((error) => {
            alert(error);
        });

        if (data) {
            // console.log(data);
            if(data.page){

            }
            if (data.data) {
                if (data.data.length > 0) {
                    let pagination_search = document.querySelector(
                        ".pagination_by_search"
                    );
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
                                        })" class="flex items-center justify-center px-1 h-4   lg:px-3 lg:h-8  md:px-1 md:h-4 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">


                                                <i class="fa-solid fa-chevron-right"></i>

                                        </li>
                        `;
                            }

                            paginationHtml += `
                               <li class="mx-2" style="margin-left:10px;">
                                        <a href="1" aria-current="page"
                                            class="z-10 flex items-center justify-center px-1 h-4   lg:px-3 lg:h-8  md:px-1 md:h-4 leading-tight text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">
                                            <i class="fa-solid fa-filter-circle-xmark" style="color: #ff0000;"></i>
                                        </a>
                                    </li>
                                    </ul>
                            <select
                                onchange="set_page_dynamic_admin_movement()"
                                id="select_page_dynamic_select_movement"
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
                                            &ensp;Total Assets: ${totalRecord} Records</span>


                                     </div>
                                     `;

                            // Finally, assign the full HTML to the element
                            pagination_search.innerHTML = paginationHtml;
                        }
                    }

                    let body_change = document.querySelector("#movement_body");
                    body_change.innerHTML = ``;

                            data.data.map((item) => {
                                    let custom = ``;
                                    custom += `
                                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">

                                                <td scope="row"
                                                    class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    ${ item.id }
                                                </td>
                                                <td scope="row"
                                                    class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white">

                                                                ${
                                                                item.created_at
                                                                    ? new Date(
                                                                            item.created_at
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
                                                    class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    ${ item.movement_no }
                                                </td>
                                                <td   scope="row"
                                                    class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    ${ item.assets_no ??''}
                                                </td>
                                                <td   scope="row"
                                                    class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    ${ item.reference ??''}
                                                </td>
                                                <td scope="row"
                                                    class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    ${ item.from_department??'' }
                                                </td>

                                                <td scope="row"
                                                    class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                ${ item.to_department??'' }
                                                </td>
                                                 <td scope="row"
                                                    class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                ${ item.from_location??'' }
                                                </td>
                                                           <td scope="row"
                                                    class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2   font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                ${ item.to_location??'' }
                                                </td>
                                    `;
                                    custom += `<td class="px-2 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2  ">`;
                                    if(item.status == 0){
                                        custom += ` <span
                                        class="inline-flex items-center bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">
                                        <span class="w-2 h-2 me-1 bg-red-500 rounded-full"></span>
                                        Inactive
                                    </span>`;

                                    }else if(item.status == 1){
                                        custom += `     <span
                                        class="inline-flex items-center bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
                                        <span class="w-2 h-2 me-1 bg-green-500 rounded-full"></span>
                                        Active
                                    </span>`;
                                    }else if(item.status == 3){
                                        custom+= `
                                              <span
                                            class="inline-flex items-center bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">
                                            <span class="w-2 h-2 me-1 bg-red-500 rounded-full"></span>
                                            Deleted
                                        </span>

                                    <span
                                        `;
                                    }
                                    custom+= ` </td>`;
                                   custom += `

                                    <td class="px-1 py-1  lg:px-6 lg:py-4  md:px-4  md:py-2 bg-gray-100 dark:bg-black  text-gray-900 whitespace-nowrap dark:text-white"
                                    style="  position: sticky; right: 0; ">
                                     `;
                                    if(item.status == 1){
                                        if(auth.permission.transfer_update == 1 && auth.permission.transfer_read == 0){
                                            custom += `<a
                                            href="/admin/movement/edit/id=${item.id}/assets_id=${item.assets_id}/varaint=${item.varaint}">
                                            <button type="button"
                                                class="text-white bg-gradient-to-r scale-50 lg:scale-100  from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"><i
                                                    class="fa-solid fa-pen-to-square" style="color: #ffffff;"></i>
                                            </button>
                                        </a>`;
                                        }else if(auth.permission.transfer_update == 0 && auth.permission.transfer_read == 1){
                                            custom+=`
                                              <a
                                            href="/admin/movement/view/id=${item.id}/assets_id=${item.assets_id}/varaint=${item.varaint}">
                                            <button type="button"
                                                class="text-white scale-50 lg:scale-100 bg-gradient-to-r from-purple-300 via-purple-500 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-500 dark:focus:ring-green-500 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                                                <i class="fa-solid  fa-eye" style="color: #ffffff;"></i>
                                            </button>
                                            </a>
                                        `;
                                        }else if(auth.permission.transfer_update == 1 && auth.permission.transfer_read == 1){
                                            custom += `
                                            <a
                                                href="/admin/movement/edit/id=${item.id}/assets_id=${item.assets_id}/varaint=${item.varaint}">
                                                <button type="button"
                                                    class="text-white bg-gradient-to-r scale-50 lg:scale-100  from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"><i
                                                        class="fa-solid fa-pen-to-square" style="color: #ffffff;"></i>
                                                </button>
                                                </a>
                                            `;
                                        }
                                        if(auth.permission.transfer_delete == 1){
                                        custom += `
                                            <button type="button" data-id="${item.id}"
                                            id="btn_delete_asset${item.id}"
                                            onclick="delete_value('btn_delete_asset'+${item.id},'delete_asset_admin','delete_value_asset')"
                                            class="scale-50 lg:scale-100 text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                                            <i class="fa-solid fa-trash" style="color: #ffffff;"></i></button>

                                        `;
                                        }
                                    }else{
                                            custom += `<a
                                        href="/admin/movement/view/id=${item.id}/assets_id=${item.assets_id}/varaint=${item.varaint}">
                                        <button type="button"
                                            class="text-white scale-50 lg:scale-100 bg-gradient-to-r from-purple-300 via-purple-500 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-500 dark:focus:ring-green-500 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                                            <i class="fa-solid  fa-eye" style="color: #ffffff;"></i>
                                        </button>
                                        </a>
                                        <div style="width: 100%; height: 100%;"> </div>`;
                                    }



                                     custom +=  `
                                            </td>
                                        </tr>
                                    `;
                        body_change.innerHTML += custom;
                    });
                    array = data.data;
                } else {
                    alert("Data not Found.");
                }
            } else {
                alert("Data not Found.");
            }
        } else {
            alert("Problem on database connection.");
        }
        document.querySelector("#loading").style.display = "none";


}


