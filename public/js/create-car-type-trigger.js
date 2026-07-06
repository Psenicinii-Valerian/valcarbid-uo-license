document.addEventListener("DOMContentLoaded", function () {
    const carTypeSelect = document.getElementById("type");
    const cylindersSelect = document.getElementById("cylinders");
    const fuelTypeSelect = document.getElementById("fuel-type");
    const transmissionTypeSelect = document.getElementById("transmission-type");
    const batteryCapacityInput = document.querySelector(
        'input[name="battery-capacity"]'
    );
    const displacementInput = document.querySelector(
        'input[name="displacement"]'
    );

    // Access oldInput data
    const oldFuelType = window.oldInput.fuelType;
    const oldCylinders = window.oldInput.cylinders;
    const oldTransmissionType = window.oldInput.transmissionType;

    const evOptions = {
        cylinders: [{ value: "null", label: window.__("Not Any") }],
        fuelType: [{ value: "electricity", label: window.__("Electricity") }],
        transmissionType: [
            { value: "automatic transmission", label: window.__("Automatic") },
        ],
    };

    const iceOptions = {
        cylinders: [
            { value: "3", label: window.__("3 Cylinders") },
            { value: "4", label: window.__("4 Cylinders") },
            { value: "6", label: window.__("6 Cylinders") },
            { value: "8", label: window.__("8 Cylinders") },
            { value: "12", label: window.__("12 Cylinders") },
        ],
        fuelType: [
            { value: "gasoline", label: window.__("Gasoline") },
            { value: "diesel", label: window.__("Diesel") },
            { value: "ethanol", label: window.__("Ethanol") },
            { value: "hybrid", label: window.__("Hybrid") },
        ],
        transmissionType: [
            { value: "manual transmission", label: window.__("Manual") },
            { value: "automatic transmission", label: window.__("Automatic") },
            { value: "cvt", label: window.__("CVT") },
        ],
    };

    carTypeSelect.addEventListener("change", function () {
        const selectedCarType = carTypeSelect.value;

        // Reset all select options and input fields
        cylindersSelect.innerHTML = "";
        fuelTypeSelect.innerHTML = "";
        transmissionTypeSelect.innerHTML = "";

        // Disable both input fields initially
        displacementInput.setAttribute("disabled", "disabled");
        displacementInput.style.display = "none";

        batteryCapacityInput.setAttribute("disabled", "disabled");
        batteryCapacityInput.style.display = "none";

        // Determine which set of options to use based on the selected car type
        const options = selectedCarType === "ev" ? evOptions : iceOptions;

        // Populate the select elements with options
        for (const option of options.cylinders) {
            const optionElement = document.createElement("option");
            optionElement.value = option.value;
            optionElement.text = option.label;
            cylindersSelect.appendChild(optionElement);
        }

        for (const option of options.fuelType) {
            const optionElement = document.createElement("option");
            optionElement.value = option.value;
            optionElement.text = option.label;
            fuelTypeSelect.appendChild(optionElement);
        }

        for (const option of options.transmissionType) {
            const optionElement = document.createElement("option");
            optionElement.value = option.value;
            optionElement.text = option.label;
            transmissionTypeSelect.appendChild(optionElement);
        }

        // Show/hide input fields based on the selected car type
        if (selectedCarType === "ev") {
            batteryCapacityInput.style.display = "block";
            batteryCapacityInput.removeAttribute("disabled");
        } else if (selectedCarType === "ice") {
            displacementInput.style.display = "block";
            displacementInput.removeAttribute("disabled");
        }
    });

    // Trigger the change event initially to set the defaults based on the selected car type
    carTypeSelect.dispatchEvent(new Event("change"));

    if (oldFuelType) {
        fuelTypeSelect.value = oldFuelType;
    } 
    if (oldCylinders) {
        cylindersSelect.value = oldCylinders;
    } 

    if (oldTransmissionType ) {
        transmissionTypeSelect.value = oldTransmissionType ;
    } 
});
