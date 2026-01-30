<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cara Admin Dashboard</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Spartan:wght@100;200;300;400;500;600;700;800;900&display=swap');

        :root {
            --primary: #088178;
            --dark: #1a1a1a;
            --light: #f4f6f8;
            --grey: #909296;
            --white: #ffffff;
            --shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            --border-radius: 10px;
            --danger: #ff3366;
            --warning: #ffad33;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Spartan', sans-serif; }
        body { background: var(--light); display: flex; min-height: 100vh; overflow-x: hidden; }
        a { text-decoration: none; color: inherit; }
        ul { list-style: none; }

        /* Sidebar & Layout Styles */
        .sidebar { width: 260px; background: var(--white); height: 100vh; position: fixed; top: 0; left: 0; z-index: 100; border-right: 1px solid #eee; display: flex; flex-direction: column; transition: 0.3s; }
        .brand { height: 70px; display: flex; align-items: center; justify-content: center; border-bottom: 1px solid #f0f0f0; }
        .brand h2 { color: var(--primary); font-size: 22px; font-weight: 700; }
        .sidebar-menu { flex: 1; padding: 20px 0; overflow-y: auto; }
        .sidebar-menu a { display: flex; align-items: center; padding: 12px 25px; font-size: 15px; color: #555; transition: 0.3s; border-left: 4px solid transparent; cursor: pointer; }
        .sidebar-menu a:hover, .sidebar-menu a.active { background: #eef7f6; color: var(--primary); border-left-color: var(--primary); font-weight: 600; }
        .sidebar-menu a i { font-size: 18px; margin-right: 15px; width: 25px; text-align: center;}

        .main-content { margin-left: 260px; flex: 1; padding: 20px 30px; transition: 0.3s; }

        header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; background: var(--white); padding: 15px 30px; border-radius: var(--border-radius); box-shadow: var(--shadow); }
        .header-title h2 { font-size: 22px; margin-bottom: 5px; color: var(--dark); }
        .header-title span { color: var(--grey); font-size: 13px; }
        .user-profile { display: flex; align-items: center; gap: 10px; cursor: pointer; }
        .user-profile img { width: 40px; height: 40px; border-radius: 50%; }
        .user-info h4 { font-size: 14px; margin-bottom: 0; color: var(--dark); }
        .user-info small { color: var(--grey); font-size: 12px; }

        /* Dashboard Cards */
        .cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .card-single { background: var(--white); padding: 25px; border-radius: var(--border-radius); box-shadow: var(--shadow); display: flex; justify-content: space-between; align-items: center; transition: 0.3s; }
        .card-single:hover { transform: translateY(-5px); }
        .card-info h1 { font-size: 24px; margin-bottom: 5px; color: var(--dark); }
        .card-info span { color: var(--grey); font-size: 14px; }
        .card-icon { width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 20px; }
        
        .bg-1 { background: #e6f7f6; color: var(--primary); }
        .bg-2 { background: #fff4e6; color: #ffad33; }
        .bg-3 { background: #e6f0ff; color: #3385ff; }
        .bg-4 { background: #fce6eb; color: #ff3366; }

        /* Tables */
        .card-table { background: var(--white); border-radius: var(--border-radius); box-shadow: var(--shadow); padding: 20px; margin-bottom: 30px; overflow-x: auto; }
        .card-header { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #f0f0f0; padding-bottom: 15px; margin-bottom: 15px; }
        .card-header h3 { font-size: 18px; color: var(--dark); }

        table { width: 100%; border-collapse: collapse; min-width: 700px; }
        thead th { text-align: left; padding: 15px 10px; font-size: 13px; color: var(--dark); background: #f9f9f9; font-weight: 700; }
        tbody td { padding: 15px 10px; font-size: 14px; color: #555; border-bottom: 1px solid #f0f0f0; vertical-align: middle; }
        .product-img { width: 45px; height: 45px; border-radius: 5px; object-fit: cover; border: 1px solid #eee; }

        /* Buttons & Status */
        .btn-action { background: var(--primary); color: #fff; padding: 8px 15px; border-radius: 5px; font-size: 13px; border: none; cursor: pointer; transition: 0.2s; font-family: 'Spartan', sans-serif; white-space: nowrap; }
        .btn-action:hover { background: #066661; }
        .btn-delete { background: var(--danger); color: white; }
        .btn-delete:hover { background: #d62450; }
        .btn-edit { background: var(--warning); color: white; }
        .btn-edit:hover { background: #e09218; }
        .action-group { display: flex; gap: 5px; white-space: nowrap; }
        .status { padding: 5px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; display: inline-block; }
        .status.pending { background: #fff8e6; color: #ffad33; }
        .status.shipping { background: #e6f0ff; color: #3385ff; }
        .status.completed { background: #e6f7f6; color: var(--primary); }

        /* Logic Tab */
        .section-content { display: none; animation: fadeIn 0.4s; }
        .section-content.active { display: block; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

        /* Modal */
        .modal { display: none; position: fixed; z-index: 2000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; }
        .modal-content { background: #fff; padding: 30px; border-radius: var(--border-radius); width: 500px; max-width: 90%; position: relative; }
        .close { position: absolute; right: 20px; top: 15px; font-size: 24px; cursor: pointer; color: #aaa; }
        .close:hover { color: #000; }
        textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; margin: 15px 0; min-height: 100px; font-family: inherit; }

        @media (max-width: 768px) {
            .sidebar { left: -260px; }
            .sidebar.active { left: 0; }
            .main-content { margin-left: 0; }
            #menu-toggle { display: block !important; font-size: 24px; cursor: pointer; margin-right: 15px; }
        }
        #menu-toggle { display: none; }
    </style>
</head>
<body>