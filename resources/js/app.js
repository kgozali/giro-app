// require('./bootstrap');
//require('./vendor/laravel-datagrid/laravel-datagrid');
import { Grid, html } from "gridjs";
import "gridjs/dist/theme/mermaid.css";

const TABLE_CLIENTS = '[js-hook-table-client]'

// Get the table element
const table_clients_wrapper = document.querySelector(TABLE_CLIENTS);

// Get the url attribute
const table_clients_url = table_clients_wrapper.getAttribute('js-hook-url');

const table_clients = new Grid({
    columns: [
        {
            name: 'No. Giro'
        },
        {
            name: 'Tgl. Bukaan Giro'
        },
        {
            name: 'Nominal'
        },
        {
            name: 'Nama Toko'
        },
        {
            name: 'Edit',
            // Here we inject our route edit
            formatter: (_, row) => html(`<a href='${row.cells[4].data}'>Edit</a>`)
        }
    ],
    search: {
        enabled: true
    },
    // server: {
    //     // Here we give the URL we passed in the hook
    //     url: table_clients_url,
    //     then: data => data.map(table => [table.giro_number, table.giro_date, table.amount, table.customer_name, table.edit_url]),
    //     handle: (res) => {
    //         // no matching records found
    //         if (res.status === 404) return {data: []};
    //         if (res.ok) return res.json();

    //         throw Error('oh no :(');
    //     },
    // },
    pagination: {
        enabled: true,
        limit: 10,
        summary: false
    },
}).render(table_clients_wrapper);

