'use strict';

jQuery(function ($) {
    class EKWC_Chart_Size_Handler {
        constructor() {
            this.tableSelector  = '.ekwc-table-form';
            this.table          = $( this.tableSelector );
            this.tableDataInput = $( '#ekwc_table_data' );
            this.init();
        }

        init() {
            this.bindEvents();
            this.initColorPickers(document);
            this.updateTableData(); // Sync data on load
        }

        bindEvents() {
            $( document.body ).on( 'click', this.tableSelector + ' .ekwc-add-row', this.addRow.bind( this ) );
            $( document.body ).on( 'click', this.tableSelector + ' .ekwc-remove-row', this.removeRow.bind( this ) );
            $( document.body ).on( 'click', this.tableSelector + ' .ekwc-add-col', this.addColumn.bind( this ) );
            $( document.body ).on( 'click', this.tableSelector + ' .ekwc-remove-col', this.removeColumn.bind( this ) );
            $( document.body ).on( 'keyup', this.tableSelector + ' .ekwc-cell-input', this.updateTableData.bind( this ) );
        }

        addRow(e) {
            e.preventDefault();
            const row       = $(e.currentTarget).closest('tr'),
                  newRow    = row.clone(true);

            newRow.find('input').val('');
            row.after(newRow);
            this.updateTableData();
        }

        removeRow(e) {
            e.preventDefault();
            const row = $(e.currentTarget).closest('tr');
            if (this.table.find('tbody tr').length > 1) {
                row.remove();
                this.updateTableData();
            }
        }

        addColumn(e) {
            e.preventDefault();
        
            const th        = $(e.currentTarget).closest('th'),
                  colIndex  = th.index(); // This includes the first "Actions" <th>
        
            // Insert new column header after the current one
            const newHeader = $(`
                <th>
                    <div class="ekwc-col-actions">
                        <button type="button" class="button ekwc-add-col">Add</button>
                        <button type="button" class="button ekwc-remove-col">Remove</button>
                    </div>
                </th>
            `);
            th.after(newHeader);
        
            // Now update each row to insert a new <td> in the correct position
            this.table.find('tbody tr').each(function () {
                const cells     = $(this).find('td'),
                      newCell   = $('<td><input type="text" name="ekwc_table_cell[]" class="ekwc-cell-input" value="" /></td>');
        
                // Adjust index because the first cell is for row actions
                cells.eq(colIndex).after(newCell);
            });
        
            this.updateTableData();
        }
            

        removeColumn(e) {
            e.preventDefault();
            const th        = $(e.currentTarget).closest('th'),
                  colIndex  = th.index();

            if (this.table.find('thead th').length > 2) {
                // Remove column header
                th.remove();

                // Remove column in each row
                this.table.find('tbody tr').each(function () {
                    $(this).find('td').eq(colIndex).remove();
                });

                this.updateTableData();
            }
        }

        updateTableData() {
            const tableData = [];

            this.table.find('tbody tr').each(function () {
                const row = [];
                $(this).find('td:not(:first-child)').each(function () {
                    const inputVal = $(this).find('input').val().trim();
                    row.push(inputVal || '&nbsp;');
                });
                tableData.push(row);
            });

            this.tableDataInput.val(JSON.stringify(tableData));
        }

        initColorPickers(context) {
            $(context).find('.ekwc-color-picker').each(function () {
                $(this).wpColorPicker();
            });
        }
    }

    // Init class
    new EKWC_Chart_Size_Handler();
});
