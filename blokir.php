<style type="text/css">
    #grid {
        margin: 1px 1px;
        border: 1px solid black;
        padding: 0;
        border-collapse: collapse;
        font-family: Calibri, sans-serif;
        font-size: 12px;
    }

    thead tr {
        border-bottom: 1px solid black;
        background: #A7C9B8;
    }
    
    thead tr:hover {
        background: #A7C9B8;
    }

    tr {
        height: 20px;
    }
    
    tr:hover {
        background-color: #ccc;
    }

    tr:nth-child(even) {
        background: #B7E9F7;
    }
    
    tr:nth-child(even):hover {
        background: #ccc;
    }

    td {
        padding: 0 10px;
        width: auto;
    }
    
    td:hover {
        cursor: pointer;
    }

    td:last-child {
        text-align: center;
        width: 60px;
        min-width: 60px;
        max-width: 60px;
    }
</style>
<div id="div_grid">
    <input type="text" id="cari" placeHolder="Cari"/><input type="submit" value="Refresh" id="refresh">
    <table id="grid">
        <thead>
            <tr>
                <th>ID</th>
                <th>KDDEPT</th>
                <th>KDUNIT</th>
                <th>KDSATKER</th>
                <th>NAMA SATKER</th>
                <th>HAK AKSES</th>
                <th>Username</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/blokir.js"></script>