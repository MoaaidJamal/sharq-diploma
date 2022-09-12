 // select
 const label = document.querySelector('.dropdown__filter-selected')
 const options = Array.from(document.querySelectorAll('.dropdown__select-option'))

 options.forEach((option) => {
   option.addEventListener('click', () => {
     label.innerHTML = option.innerHTML
     var country = option.getAttribute("data-country")
     console.log("Country : ", country)
   })
 })

 // Close dropdown onclick outside
 document.addEventListener('click', (e) => {
   const toggle = document.querySelector('.dropdown__switch')
   const element = e.target

   if (element == toggle) return;

   const isDropdownChild = element.closest('.dropdown__filter')

   if (!isDropdownChild) {
     toggle.checked = false
   }
 })

 $(document).on('click', '.dropdown__select-option', function () {
     $('#country_id').val($(this).find('.ordersubmitbytable').data('id'))
 });