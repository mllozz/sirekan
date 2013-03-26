<style type="text/css">
    #grid {
        margin: 1px 1px;
        border: 1px solid black;
        font-family: Calibri, sans-serif;
        font-size: 12px;
        width: 50%;
        text-align: left;
    }

    thead tr {
        border-bottom: 1px solid black;
        background: #A7C9B8;
        text-align: center;
    }

    thead tr:hover {
        background: #A7C9B8;
    }

    tr {
        height: 20px;
        text-align: left;
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
        padding: 0 2px;
        text-align: left;
    }

    td:hover {
        cursor: pointer;
    }

    #grid td:last-child {
        text-align: left;
        width: 280px;
    }
    
    input[type=text], option {
        background-color: #fbec88;
        border-width: 1px;
    }
    

</style>
<form id="ceksakpa" method="post" action="">
    <table id="grid">
        <thead>
        <th colspan="2">Cek Hasil Rekonsiliasi SAKPA</th>
        </thead>
        <tr>
            <th>Kode Satker</th>
            <td id="kdsatker"></td>
        </tr>
        <tr>
            <th>Nama Satker</th>
            <td id="nmsatker"></td>
        </tr>
        <tr>
            <th>Periode</th>
            <td>
                <select id="periode">    
                </select>
            </td>
        </tr>
        <tr>
            <th>Jenis Rekonsiliasi</th>
            <td>
                <select id="jenis_rekon">
                    <option value="1">Realisasi Belanja</option>
                    <option value="2">Realisasi Pengembalian Belanja</option>
                    <option value="3">Realisasi Pendapatan Non Pajak</option>
                    <option value="4">Realisasi Pendapatan Pajak</option>
                    <option value="5">Realisasi Penerimaan Pembiayaan</option>
                    <option value="6">Realisasi Pengeluaran Pembiayaan</option>
                    <option value="7">Realisasi Mutasi Uang Persediaan</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" id="cek_rekon" value="Cek"/></td>
        </tr>
    </table>
</form>

<script type="text/javascript" src="js/cek_sakpa.js"></script>