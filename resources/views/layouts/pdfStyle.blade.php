<style>
    @page {
        header: page-header;
        footer: page-footer;
    }
    body, h1,h2,h3,h4,h5, table,tr,td {
        font-family: 'iransans1', sans-serif;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #212529;
        text-align: right;
        direction: rtl;
    }
    h1, h2, h3, h4, h5, h6 {
        margin-top: 0;
        margin-bottom: 0.5rem;
    }

    p {
        margin-top: 0;
        margin-bottom: 1rem;
    }

    h1, .h1 {
        font-size: 2.5rem;
    }

    h2, .h2 {
        font-size: 2rem;
    }

    h3, .h3 {
        font-size: 1.75rem;
    }

    h4, .h4 {
        font-size: 1.5rem;
    }

    h5, .h5 {
        font-size: 1.25rem;
    }

    h6, .h6 {
        font-size: 1rem;
    }
    .container-fluid {
        width: 100%;
        padding-right: 15px;
        padding-left: 15px;
        margin-right: auto;
        margin-left: auto;
    }
    .row {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        margin-right: -15px;
        margin-left: -15px;
    }

    .no-gutters {
        margin-right: 0;
        margin-left: 0;
    }

    .table {
        width: 100%;
        margin-bottom: 1rem;
        background-color: transparent;
    }

    .table th,
    .table td {
        padding: 0.75rem;
        vertical-align: top;
        border-top: 1px solid #dee2e6;
    }

    .table thead th {
        vertical-align: bottom;
        border-bottom: 2px solid #dee2e6;
    }

    .table tbody + tbody {
        border-top: 2px solid #dee2e6;
    }

    .table .table {
        background-color: #fff;
    }

    .table-sm th,
    .table-sm td {
        padding: 0.3rem;
        font-size: 10px;
    }
    .table-sm td h5{
        font-size: 5px;
    }

    .table-bordered {
        border: 1px solid #dee2e6;
    }

    .table-bordered th,
    .table-bordered td {
        border: 1px solid #dee2e6;
    }

    .table-bordered thead th,
    .table-bordered thead td {
        border-bottom-width: 2px;
    }

    .table-borderless th,
    .table-borderless td,
    .table-borderless thead th,
    .table-borderless tbody + tbody {
        border: 0;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(0, 0, 0, 0.05);
    }

    .table-hover tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.075);
    }

    .table-primary,
    .table-primary > th,
    .table-primary > td {
        background-color: #b8daff;
    }

    .table-primary th,
    .table-primary td,
    .table-primary thead th,
    .table-primary tbody + tbody {
        border-color: #7abaff;
    }

    .table-hover .table-primary:hover {
        background-color: #9fcdff;
    }

    .table-hover .table-primary:hover > td,
    .table-hover .table-primary:hover > th {
        background-color: #9fcdff;
    }

    .table-secondary,
    .table-secondary > th,
    .table-secondary > td {
        background-color: #d6d8db;
    }

    .table-secondary th,
    .table-secondary td,
    .table-secondary thead th,
    .table-secondary tbody + tbody {
        border-color: #b3b7bb;
    }

    .table-hover .table-secondary:hover {
        background-color: #c8cbcf;
    }

    .table-hover .table-secondary:hover > td,
    .table-hover .table-secondary:hover > th {
        background-color: #c8cbcf;
    }

    .table-success,
    .table-success > th,
    .table-success > td {
        background-color: #c3e6cb;
    }

    .table-success th,
    .table-success td,
    .table-success thead th,
    .table-success tbody + tbody {
        border-color: #8fd19e;
    }

    .table-hover .table-success:hover {
        background-color: #b1dfbb;
    }

    .table-hover .table-success:hover > td,
    .table-hover .table-success:hover > th {
        background-color: #b1dfbb;
    }

    .table-info,
    .table-info > th,
    .table-info > td {
        background-color: #bee5eb;
    }

    .table-info th,
    .table-info td,
    .table-info thead th,
    .table-info tbody + tbody {
        border-color: #86cfda;
    }

    .table-hover .table-info:hover {
        background-color: #abdde5;
    }

    .table-hover .table-info:hover > td,
    .table-hover .table-info:hover > th {
        background-color: #abdde5;
    }

    .table-warning,
    .table-warning > th,
    .table-warning > td {
        background-color: #ffeeba;
    }

    .table-warning th,
    .table-warning td,
    .table-warning thead th,
    .table-warning tbody + tbody {
        border-color: #ffdf7e;
    }

    .table-hover .table-warning:hover {
        background-color: #ffe8a1;
    }

    .table-hover .table-warning:hover > td,
    .table-hover .table-warning:hover > th {
        background-color: #ffe8a1;
    }

    .table-danger,
    .table-danger > th,
    .table-danger > td {
        background-color: #f5c6cb;
    }

    .table-danger th,
    .table-danger td,
    .table-danger thead th,
    .table-danger tbody + tbody {
        border-color: #ed969e;
    }

    .table-hover .table-danger:hover {
        background-color: #f1b0b7;
    }

    .table-hover .table-danger:hover > td,
    .table-hover .table-danger:hover > th {
        background-color: #f1b0b7;
    }

    .table-light,
    .table-light > th,
    .table-light > td {
        background-color: #fdfdfe;
    }

    .table-light th,
    .table-light td,
    .table-light thead th,
    .table-light tbody + tbody {
        border-color: #fbfcfc;
    }

    .table-hover .table-light:hover {
        background-color: #ececf6;
    }

    .table-hover .table-light:hover > td,
    .table-hover .table-light:hover > th {
        background-color: #ececf6;
    }

    .table-dark,
    .table-dark > th,
    .table-dark > td {
        background-color: #c6c8ca;
    }

    .table-dark th,
    .table-dark td,
    .table-dark thead th,
    .table-dark tbody + tbody {
        border-color: #95999c;
    }

    .table-hover .table-dark:hover {
        background-color: #b9bbbe;
    }

    .table-hover .table-dark:hover > td,
    .table-hover .table-dark:hover > th {
        background-color: #b9bbbe;
    }

    .table-active,
    .table-active > th,
    .table-active > td {
        background-color: rgba(0, 0, 0, 0.075);
    }

    .table-hover .table-active:hover {
        background-color: rgba(0, 0, 0, 0.075);
    }

    .table-hover .table-active:hover > td,
    .table-hover .table-active:hover > th {
        background-color: rgba(0, 0, 0, 0.075);
    }

    .table .thead-dark th {
        color: #fff;
        background-color: #212529;
        border-color: #32383e;
    }

    .table .thead-light th {
        color: #495057;
        background-color: #e9ecef;
        border-color: #dee2e6;
    }

    .table-dark {
        color: #fff;
        background-color: #212529;
    }

    .table-dark th,
    .table-dark td,
    .table-dark thead th {
        border-color: #32383e;
    }

    .table-dark.table-bordered {
        border: 0;
    }

    .table-dark.table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(255, 255, 255, 0.05);
    }

    .table-dark.table-hover tbody tr:hover {
        background-color: rgba(255, 255, 255, 0.075);
    }

    .border {
        border: 1px solid #dee2e6 !important;
    }

    .border-top {
        border-top: 1px solid #dee2e6 !important;
    }

    .border-right {
        border-right: 1px solid #dee2e6 !important;
    }

    .border-bottom {
        border-bottom: 1px solid #dee2e6 !important;
    }

    .border-left {
        border-left: 1px solid #dee2e6 !important;
    }

    .border-0 {
        border: 0 !important;
    }

    .border-top-0 {
        border-top: 0 !important;
    }

    .border-right-0 {
        border-right: 0 !important;
    }

    .border-bottom-0 {
        border-bottom: 0 !important;
    }

    .border-left-0 {
        border-left: 0 !important;
    }

    .border-primary {
        border-color: #007bff !important;
    }

    .border-secondary {
        border-color: #6c757d !important;
    }

    .border-success {
        border-color: #28a745 !important;
    }

    .border-info {
        border-color: #17a2b8 !important;
    }

    .border-warning {
        border-color: #ffc107 !important;
    }

    .border-danger {
        border-color: #dc3545 !important;
    }

    .border-light {
        border-color: #f8f9fa !important;
    }

    .border-dark {
        border-color: #343a40 !important;
    }

    .border-white {
        border-color: #fff !important;
    }

    .m-0 {
        margin: 0 !important;
    }

    .mt-0,
    .my-0 {
        margin-top: 0 !important;
    }

    .mr-0,
    .mx-0 {
        margin-right: 0 !important;
    }

    .mb-0,
    .my-0 {
        margin-bottom: 0 !important;
    }

    .ml-0,
    .mx-0 {
        margin-left: 0 !important;
    }

    .m-1 {
        margin: 0.25rem !important;
    }

    .mt-1,
    .my-1 {
        margin-top: 0.25rem !important;
    }

    .mr-1,
    .mx-1 {
        margin-right: 0.25rem !important;
    }

    .mb-1,
    .my-1 {
        margin-bottom: 0.25rem !important;
    }

    .ml-1,
    .mx-1 {
        margin-left: 0.25rem !important;
    }

    .m-2 {
        margin: 0.5rem !important;
    }

    .mt-2,
    .my-2 {
        margin-top: 0.5rem !important;
    }

    .mr-2,
    .mx-2 {
        margin-right: 0.5rem !important;
    }

    .mb-2,
    .my-2 {
        margin-bottom: 0.5rem !important;
    }

    .ml-2,
    .mx-2 {
        margin-left: 0.5rem !important;
    }

    .m-3 {
        margin: 1rem !important;
    }

    .mt-3,
    .my-3 {
        margin-top: 1rem !important;
    }

    .mr-3,
    .mx-3 {
        margin-right: 1rem !important;
    }

    .mb-3,
    .my-3 {
        margin-bottom: 1rem !important;
    }

    .ml-3,
    .mx-3 {
        margin-left: 1rem !important;
    }

    .m-4 {
        margin: 1.5rem !important;
    }

    .mt-4,
    .my-4 {
        margin-top: 1.5rem !important;
    }

    .mr-4,
    .mx-4 {
        margin-right: 1.5rem !important;
    }

    .mb-4,
    .my-4 {
        margin-bottom: 1.5rem !important;
    }

    .ml-4,
    .mx-4 {
        margin-left: 1.5rem !important;
    }

    .m-5 {
        margin: 3rem !important;
    }

    .mt-5,
    .my-5 {
        margin-top: 3rem !important;
    }

    .mr-5,
    .mx-5 {
        margin-right: 3rem !important;
    }

    .mb-5,
    .my-5 {
        margin-bottom: 3rem !important;
    }

    .ml-5,
    .mx-5 {
        margin-left: 3rem !important;
    }

    .p-0 {
        padding: 0 !important;
    }

    .pt-0,
    .py-0 {
        padding-top: 0 !important;
    }

    .pr-0,
    .px-0 {
        padding-right: 0 !important;
    }

    .pb-0,
    .py-0 {
        padding-bottom: 0 !important;
    }

    .pl-0,
    .px-0 {
        padding-left: 0 !important;
    }

    .p-1 {
        padding: 0.25rem !important;
    }

    .pt-1,
    .py-1 {
        padding-top: 0.25rem !important;
    }

    .pr-1,
    .px-1 {
        padding-right: 0.25rem !important;
    }

    .pb-1,
    .py-1 {
        padding-bottom: 0.25rem !important;
    }

    .pl-1,
    .px-1 {
        padding-left: 0.25rem !important;
    }

    .p-2 {
        padding: 0.5rem !important;
    }

    .pt-2,
    .py-2 {
        padding-top: 0.5rem !important;
    }

    .pr-2,
    .px-2 {
        padding-right: 0.5rem !important;
    }

    .pb-2,
    .py-2 {
        padding-bottom: 0.5rem !important;
    }

    .pl-2,
    .px-2 {
        padding-left: 0.5rem !important;
    }

    .p-3 {
        padding: 1rem !important;
    }

    .pt-3,
    .py-3 {
        padding-top: 1rem !important;
    }

    .pr-3,
    .px-3 {
        padding-right: 1rem !important;
    }

    .pb-3,
    .py-3 {
        padding-bottom: 1rem !important;
    }

    .pl-3,
    .px-3 {
        padding-left: 1rem !important;
    }

    .p-4 {
        padding: 1.5rem !important;
    }

    .pt-4,
    .py-4 {
        padding-top: 1.5rem !important;
    }

    .pr-4,
    .px-4 {
        padding-right: 1.5rem !important;
    }

    .pb-4,
    .py-4 {
        padding-bottom: 1.5rem !important;
    }

    .pl-4,
    .px-4 {
        padding-left: 1.5rem !important;
    }

    .p-5 {
        padding: 3rem !important;
    }

    .pt-5,
    .py-5 {
        padding-top: 3rem !important;
    }

    .pr-5,
    .px-5 {
        padding-right: 3rem !important;
    }

    .pb-5,
    .py-5 {
        padding-bottom: 3rem !important;
    }

    .pl-5,
    .px-5 {
        padding-left: 3rem !important;
    }

    .m-n1 {
        margin: -0.25rem !important;
    }

    .mt-n1,
    .my-n1 {
        margin-top: -0.25rem !important;
    }

    .mr-n1,
    .mx-n1 {
        margin-right: -0.25rem !important;
    }

    .mb-n1,
    .my-n1 {
        margin-bottom: -0.25rem !important;
    }

    .ml-n1,
    .mx-n1 {
        margin-left: -0.25rem !important;
    }

    .m-n2 {
        margin: -0.5rem !important;
    }

    .mt-n2,
    .my-n2 {
        margin-top: -0.5rem !important;
    }

    .mr-n2,
    .mx-n2 {
        margin-right: -0.5rem !important;
    }

    .mb-n2,
    .my-n2 {
        margin-bottom: -0.5rem !important;
    }

    .ml-n2,
    .mx-n2 {
        margin-left: -0.5rem !important;
    }

    .m-n3 {
        margin: -1rem !important;
    }

    .mt-n3,
    .my-n3 {
        margin-top: -1rem !important;
    }

    .mr-n3,
    .mx-n3 {
        margin-right: -1rem !important;
    }

    .mb-n3,
    .my-n3 {
        margin-bottom: -1rem !important;
    }

    .ml-n3,
    .mx-n3 {
        margin-left: -1rem !important;
    }

    .m-n4 {
        margin: -1.5rem !important;
    }

    .mt-n4,
    .my-n4 {
        margin-top: -1.5rem !important;
    }

    .mr-n4,
    .mx-n4 {
        margin-right: -1.5rem !important;
    }

    .mb-n4,
    .my-n4 {
        margin-bottom: -1.5rem !important;
    }

    .ml-n4,
    .mx-n4 {
        margin-left: -1.5rem !important;
    }

    .m-n5 {
        margin: -3rem !important;
    }

    .mt-n5,
    .my-n5 {
        margin-top: -3rem !important;
    }

    .mr-n5,
    .mx-n5 {
        margin-right: -3rem !important;
    }

    .mb-n5,
    .my-n5 {
        margin-bottom: -3rem !important;
    }

    .ml-n5,
    .mx-n5 {
        margin-left: -3rem !important;
    }

    .m-auto {
        margin: auto !important;
    }

    .mt-auto,
    .my-auto {
        margin-top: auto !important;
    }

    .mr-auto,
    .mx-auto {
        margin-right: auto !important;
    }

    .mb-auto,
    .my-auto {
        margin-bottom: auto !important;
    }

    .ml-auto,
    .mx-auto {
        margin-left: auto !important;
    }
    .img-thumbnail {
        padding: 0.25rem;
        background-color: #fff;
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
        max-width: 100%;
        height: auto;
    }
</style>
