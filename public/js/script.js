const sidebarToggle = document.querySelector("#sidebar-toggle");
sidebarToggle.addEventListener("click",function(){
    document.querySelector("body").classList.toggle("collapsed");
});

// dropdown
$(document).ready(function () {
    // Handle select all logic within a specific dropdown
    $(".dropdown-menu").on("click", function (e) {
      e.stopPropagation(); // Prevent dropdown from closing on click
    });
  
    $(".selectall").on("change", function () {
      const dropdown = $(this).closest(".dropdown-menu");
      const isChecked = $(this).is(":checked");
      dropdown.find(".justone").prop("checked", isChecked);
      updateDropdownText(dropdown);
      dropdown.find(".select-text").text(isChecked ? " Deselect All" : " Select All");
    });
  
    $(".justone").on("change", function () {
      const dropdown = $(this).closest(".dropdown-menu");
      const totalCheckboxes = dropdown.find(".justone").length;
      const checkedCheckboxes = dropdown.find(".justone:checked").length;
  
      dropdown.find(".selectall").prop("checked", totalCheckboxes === checkedCheckboxes);
      dropdown.find(".select-text").text(totalCheckboxes === checkedCheckboxes ? " Deselect All" : " Select All");
  
      updateDropdownText(dropdown);
    });
  
    function updateDropdownText(dropdown) {
      const selectedCount = dropdown.find(".justone:checked").length;
      dropdown.siblings("button").find(".dropdown-text").text(`(${selectedCount}) Selected`);
    }
  });
  

