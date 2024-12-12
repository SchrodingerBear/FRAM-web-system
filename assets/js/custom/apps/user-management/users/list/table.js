// Ensure strict mode is enabled
'use strict'

// DataTable Initialization Function
var KTUsersList = (function () {
  var tableElement = document.getElementById('kt_table_users')

  return {
    init: function () {
      if (tableElement) {
        // Initialize DataTable
        var dataTable = $(tableElement).DataTable({
          info: false, // Disable info text ("Showing X of Y entries")
          order: [], // No default ordering
          pageLength: 10, // Default number of rows per page
          lengthChange: false, // Disable ability to change page length
          columnDefs: [
            { orderable: false, targets: 0 } // Make first column non-orderable
          ]
        })

        // Check for 'search' parameter in URL
        var urlParams = new URLSearchParams(window.location.search)
        var searchQuery = urlParams.get('search')
        if (searchQuery) {
          dataTable.search(searchQuery).draw()
          // Optionally set the value in the search input field, if present
          var searchInput = document.querySelector(
            '[data-kt-user-table-filter="search"]'
          )
          if (searchInput) {
            searchInput.value = searchQuery
          }
        }

        // Search Input Feature
        var searchInput = document.querySelector(
          '[data-kt-user-table-filter="search"]'
        )
        if (searchInput) {
          searchInput.addEventListener('keyup', function (event) {
            dataTable.search(event.target.value).draw()
          })
        }
      }
    }
  }
})()

// Initialize the script on DOM content load
KTUtil.onDOMContentLoaded(function () {
  KTUsersList.init()
})
