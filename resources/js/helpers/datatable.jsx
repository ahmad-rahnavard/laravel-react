import React, { Component } from 'react'
import 'datatables.net-dt/js/dataTables.dataTables'
import { storage } from './storage'
const $ = require('jquery')

export default class Home extends Component {

    componentDidMount() {
        $(`#datatable`).DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            destroy: true,
            ajax: {
                url: process.env.MIX_API_URL + 'table-data',
                data: function(data) {
                    delete data.columns
                },
                beforeSend: request => {
                    request.setRequestHeader(
                        'Authorization',
                        'Bearer ' + ((storage.token()) ? storage.token().token : undefined)
                    )
                }
            },
            columns: [
                {
                    name: 'id',
                    render: (data, type, row) => row.id,
                    visible: false,
                    searchable: false
                },
                {
                    name: '#',
                    data: null,
                    render: (data, type, row, meta) => meta.row + meta.settings._iDisplayStart + 1,
                    orderable: false
                },
                {
                    name: 'product_name',
                    render: (data, type, row) => row.product_name
                },
                {
                    name: 'product_desc',
                    render: (data, type, row) => row.product_desc
                },
                {
                    name: 'quantity',
                    render: (data, type, row) => row.quantity
                },
                {
                    name: 'price',
                    render: (data, type, row) => row.price + ' ' + row.currency
                },
                {
                    name: 'category',
                    render: (data, type, row) => row.category
                },
                {
                    name: 'image',
                    render: function(data, type, row) {
                        return '<a href="' + row.source_video + '">' +
                            '<img src="' + row.image + '" alt="" width="70" height="70"></a>'
                    },
                    orderable: false
                },
                // {
                //     'gender': '',
                //     'quantity': 15,
                //     'size': '',
                //     'style': 'architecture',
                //     'color': 'Purple',
                //     'url': '',
                //     'image_additional': 'http://dummyimage.com/157x160.jpg/ff4444/ffffff',
                //     'additional': 'test',
                // }
            ]
        })
    }

    render() {

        return (
            <table id="datatable" className="table table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>#</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Image</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>ID</th>
                    <th>#</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Image</th>
                </tr>
                </tfoot>
                <tbody></tbody>
            </table>
        )
    }
}
