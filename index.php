<html>
<head>
    <title>AI</title>
    <link rel="shortcut icon" type="image/png" href="img/ai.png"/>
    <link rel="stylesheet" href="resources/bootstrap-3.3.7/css/bootstrap.css">
    <link href="resources/validation/css/bootstrapValidator.min.css" rel="stylesheet">
    <link rel="stylesheet" href="resources/font-awesome-4.7.0/css/font-awesome.min.css">

    <style>
        body {
            margin: 0 15px 15px 15px;
            padding: 0;
        }

        .align-right {
            text-align: -webkit-right;
        }

        .align-left {
            text-align: -webkit-left;
        }

        .input_handler {
            padding-bottom: 12px;
        }

        .room_title {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 12pt;
        }

        .dirt_level_a_div {
            margin-bottom: 0;
            visibility: hidden;
        }

        .dirt_level_b_div {
            visibility: hidden;
        }

        .hide_this {
            visibility: hidden;
            transition: visibility 500ms;
        }

        .show_this {
            visibility: visible;
            transition: visibility 500ms;
        }

        .rooma td {
            height: 46px;
            width: 46px;
            text-align: center;
            border: 1px solid black;
        }

        .roomb td {
            height: 46px;
            width: 46px;
            text-align: center;
            border: 1px solid black;
        }

        .animate {
            height: 0;
            visibility: hidden;
            transition: height 1000ms;
        }

        .animate_show {
            height: auto;
            visibility: visible;
            transition: visibility 500ms;
        }

        .room_div {
            margin-top: 12px;
            text-align: -webkit-center;
        }
    </style>
</head>
<body class="clearfix panel">
<div class="row panel-heading" style=" margin:0;background: #d8f3e2">
    <div class="col-md-12 " style="text-align: center; ">
        <h4>
            Assignment 1 - AI
        </h4>
    </div>
</div>
<div class="row panel-body">
    <div class="col-md-12 room_config_div" style="text-align: center;">
        <h5 class="room_title" style="margin: 24px 0 46px 0;">Room configurations </h5>
        <form data-toggle="validator" action="scripts/createRooms.php" method="post" id="roomForm">
            <div class="row">
                <div class="col-md-5">
                    <div class="row input_handler">
                        <div class="col-md-6 align-right">
                            <label for="width" class="form-inline">
                                Room Size:
                            </label>
                        </div>
                        <div class="col-md-6 align-left">
                            <input type="number" class="form-control" id="width" max="10" required name="r_width">
                        </div>
                    </div>
                    <div class="row input_handler">
                        <div class="col-md-6 align-right">
                            <label for="vc_room" class="form-inline">
                                Vacuum cleaner is in:
                            </label>
                        </div>
                        <div class="col-md-6 align-left">
                            <select name="vc_room" required id="vc_room" class="form-control">
                                <option value="-1" selected disabled>Select room</option>
                                <option value="1">Room A</option>
                                <option value="2">Room B</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="row input_handler">
                        <div class="col-md-4 align-right">
                            <label for="dirt_room" class="form-inline">
                                Dirt is in:
                            </label>
                        </div>
                        <div class="col-md-6 align-left">
                            <select name="dirt_room" required id="dirt_room" class="form-control">
                                <option value="-1" selected disabled>Select one option</option>
                                <option value="1">Room A</option>
                                <option value="2">Room B</option>
                                <option value="3">Both</option>
                                <option value="4">None</option>
                            </select>
                        </div>
                    </div>
                    <div class="row input_handler dirt_level_a_div">
                        <div class="col-md-4 align-right">
                            <label for="dirt_level_a">
                                Dirt level for A:
                            </label>
                        </div>
                        <div class="col-md-6 align-left">
                            <select name="dirt_level_a" class="form-control" id="dirt_level_a">
                                <option value="1">Low</option>
                                <option value="2">High</option>
                            </select>
                        </div>
                    </div>
                    <div class="row input_handler dirt_level_b_div">
                        <div class="col-md-4 align-right">
                            <label for="dirt_level_b">
                                Dirt level for B:
                            </label>
                        </div>
                        <div class="col-md-6 align-left">
                            <select name="dirt_level_b" class="form-control" id="dirt_level_b">
                                <option value="1">Low</option>
                                <option value="2">High</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <input type="hidden" name="createRooms" value="1">
            <div class="row">
                <div class="col-md-5"></div>
                <div class="col-md-5 align-right">
                    <div class="row">
                        <div class="col-md-10">
                            <button type="button" id="createRoom" class="btn btn-success">
                                Create rooms
                            </button>
                        </div>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <p class="matrix"></p>
                </div>
            </div>
        </form>
    </div>

    <div class="col-md-12 cleaning_div animate" style="text-align: center;">
        <h5 class="room_title" style="margin: 24px 0 0 0;">Room cleaning ... </h5>
        <h4 class="total_energy_spent" style="margin: 24px 0 0 0;">0</h4>
        <div class="row">
            <div class="col-md-3 col-md-offset-9">
                <button class="btn btn-success" id="clean">CLEAN</button>
                <button class="btn btn-default" id="continue">Restart</button>
                <button class="btn btn-warning" id="reconfig">Reset/Config Rooms again</button>
            </div>
        </div>
        <div class="row" style="padding-top: 24px">
            <div class="col-md-6">
                <h5 style="text-align: center">Room A</h5>

                <div class="row">
                    <div class="col-md-6 align-right">
                        <p>Dirty: </p>
                    </div>
                    <div class="col-md-6 align-left">
                        <p class="roomA_dirtdiv">
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 align-right">
                        <p>Energy Spent: </p>
                    </div>
                    <div class="col-md-6 align-left">
                        <p class="roomA_energydiv bg_color">
                        </p>
                    </div>
                </div>

                <!--                Room View-->
                <div class="row room_div">
                    <div class="col-md-12">
                        <table class="roomA">
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <h5 style="text-align: center">Room B</h5>

                <div class="row">
                    <div class="col-md-6 align-right">
                        <p>Dirty: </p>
                    </div>

                    <div class="col-md-6 align-left">
                        <p class="roomB_dirtdiv">
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 align-right">
                        <p>Energy Spent: </p>
                    </div>

                    <div class="col-md-6 align-left">
                        <p class="roomB_energydiv">
                        </p>
                    </div>
                </div>

                <!--                Room view-->
                <div class="row room_div">
                    <div class="col-md-12">
                        <table class="roomB">
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="js/jquery-3.2.1.min.js"></script>
<script src="resources/validation/js/bootstrapValidator.min.js"></script>
<script>

    var form = $("#roomForm");
    var room_config_div = $(".room_config_div");
    var rooms_div = $(".cleaning_div");

    var room_a_div = $(".roomA");
    var room_b_div = $(".roomB");
    var room_a_dirt_div = $(".roomA_dirtdiv");
    var room_a_energy_div = $(".roomA_energydiv");
    var room_b_dirt_div = $(".roomB_dirtdiv");
    var room_b_energy_div = $(".roomB_energydiv");
    var total_energy_spent = $(".total_energy_spent");

    var room_cleaning_msg = $(".room_title");
    var GlobalEnergySpent = 0;

    var oneCleaningCompleted = 0;
    var roomCleanedVerctor = [];

    var MOVE_COST = 1, CLEAN_CELL = 3, CHANGE_ROOM = 2;
    var vcroom = $("#vc_room").val();
    var roomWidth = roomHeight = $("#width").val();
    var dirtRoom = $("#dirt_room").val();
    var rooma_dirt = 0, roomb_dirt = 0;

    var VC_Lastpos = vcroom;
    //inicializohen dhomat dhe fshesa me verat fillestare te parametrave
    var roomA = {
        name: 'roomA',
        id: 1,
        width: 0,
        height: 0,
        matrix: [[]],
        dirtVector: [],
        dirt_level: 0,
        dirt_rate: 0,
        clean_route: [],
        energySpent: 0
    };
    var roomB = {
        name: 'roomB',
        id: 2,
        width: 0,
        height: 0,
        matrix: [[]],
        dirtVector: [],
        dirt_level: 0,
        dirt_rate: 0,
        clean_route: [],
        energySpent: 0
    };
    var VCleaner = {
        currentPos: [0, 0],
        vcRoom: vcroom,
        vcEnergySpent: 0
    };

    function setCleanBtnListener() {
        $("#clean").on('click', function () {
            startCleaningROOMS();
        });
    }

    setCleanBtnListener();
    setCreateRoomListener();
    //klikohet per te krijuar dhomat
    function setCreateRoomListener() {
        $("#createRoom").on('click', function () {
            if (($("#width").val() > 0) && ($("#vc_room").val() > 0) && ($("#dirt_room").val() > 0)) {
                room_config_div.addClass("animate");
                room_config_div.find(".show_this").removeClass("show_this");
                room_cleaning_msg.html('Room cleaning...');
                initRoomConfig();
                initRooms();

                displayRooms();
            } else {
                validateForm();
            }
        });

    }

    function emtyRoomConfigFields() {
        form.trigger('reset');
    }
    function handleCleaningOrder() {
        console.log("VECTOR ORDER:", roomCleanedVerctor);
        if (roomCleanedVerctor.length > 1) {
            // vizaton pastrimin e dhomave sipas rradhes qe ajo eshte bere
            if (roomCleanedVerctor[0] == roomA.id){
                if (roomA.dirt_rate > 0 && roomB.dirt_rate > 0) {
                    showRoute(roomA, 0, roomB);
                }else
                    if (roomA.dirt_rate > 0 && roomB.dirt_rate === 0){
                    showRoute(roomA, 0, roomA);
                    removeVCleanerFromEmtyRoom(roomB);
                }else
                    if (roomA.dirt_rate === 0 && roomB.dirt_rate > 0){
                        removeVCleanerFromEmtyRoom(roomA);
                        showRoute(roomB, 0, roomB);
                }
            }
            else {
                if (roomB.dirt_rate > 0 && roomA.dirt_rate > 0) {
                    showRoute(roomB, 0, roomA);
                }else
                if (roomB.dirt_rate > 0 && roomA.dirt_rate === 0){
                    showRoute(roomB, 0, roomB);
                    removeVCleanerFromEmtyRoom(roomA);
                }else
                if (roomB.dirt_rate === 0 && roomA.dirt_rate > 0){
                    showRoute(roomA, 0, roomA);
                    removeVCleanerFromEmtyRoom(roomB);
                }
            }
            oneCleaningCompleted++;
            roomCleanedVerctor = [];
        }
        else {
            console.log("vc ROOM after restart: ", VCleaner.vcRoom);
            if (VCleaner.vcRoom == 1 ) {
                cleanroom(roomA, parseInt(roomA.width) + parseInt(roomA.height));
            }
            else{
                cleanroom(roomB, parseInt(roomB.width) + parseInt(roomB.height));
            }
        }
    }

    function removeVCleanerFromEmtyRoom(room){
        $('table.' + room.name).find('.fa-eraser').parent().html('');
    }

    function showRoute(room, pos, nextRoom) {
        // finishedCleaning = false;
        var cleaned_cell_color = '#5cb85c';
        room_a_energy_div.html('<span class="energy"> ' + roomA.energySpent + '</span>');
        room_b_energy_div.html('<span class="energy"> ' + roomB.energySpent + '</span>');
        console.log('animating', room.name);
        if (room.clean_route.length > 0) {
            setTimeout(function () {
                var index = room.clean_route[pos];

                $('table.' + room.name).find('.fa-eraser').parent().html('');
                var a = $('table.' + room.name + ' tr:nth-child(' + (index.x + 1) + ') td:nth-child('
                    + (index.y + 1) + ')');
                a.html('<i class="fa fa-eraser "></i> &nbsp;');
                a.css('background-color', cleaned_cell_color);

                if (room.clean_route.length > pos + 1) {
                    showRoute(room, ++pos, nextRoom)
                } else {
                    if (room.id != nextRoom.id) {
                        $('table.' + room.name).find('.fa-eraser').parent().html('');
                        pos = -1;
                        showRoute(nextRoom, ++pos, nextRoom)
                    } else {
                        roomA.energySpent = 0;
                        roomB.energySpent = 0;
                        VCleaner.vcEnergySpent += CHANGE_ROOM;
                        GlobalEnergySpent+= VCleaner.vcEnergySpent
                        total_energy_spent.html(GlobalEnergySpent);
                        room_cleaning_msg.html('Përfundoi me sukses <span class="btn-success"><i class="fa fa-check"></i></span>');
                        console.log("DONE:", " first-> "+room.id+" next-> "+nextRoom.id)
                    }
                }
            }, 500);
        }
        else {
            showRoute(nextRoom, ++pos, nextRoom);
            roomA.energySpent = 0;
            roomB.energySpent = 0;
            GlobalEnergySpent+= VCleaner.vcEnergySpent
            total_energy_spent.html(GlobalEnergySpent);
            room_cleaning_msg.html('Përfundoi me sukses <span class="btn-success"><i class="fa fa-check"></i></span>');
            console.log("DONE _2:", " first-> "+room.id+" next-> "+nextRoom.id)
        }
    }

    function displayRooms() {
        room_a_div.html(printoRoom(roomA, VCleaner.vcRoom == 1));
        room_b_div.html(printoRoom(roomB, VCleaner.vcRoom == 2));
        room_a_dirt_div.html(defineDirtLevelHtml(roomA.dirt_level) + ' <span class="dirt_rate"> ' + roomA.dirt_rate + ' %</span>');
        room_b_dirt_div.html(defineDirtLevelHtml(roomB.dirt_level) + ' <span class="dirt_rate"> ' + roomB.dirt_rate + ' %</span>');
        room_b_energy_div.html('<span class="energy"> ' + roomB.energySpent + '</span>');
        room_a_energy_div.html('<span class="energy"> ' + roomA.energySpent + '</span>');

        rooms_div.removeClass('animate');
        rooms_div.addClass('animate_show');
    }

    function defineDirtLevelHtml(dirt_level) {
        if (dirt_level == 2) {
            return '<i class="fa btn-danger fa-2x fa-trash-o high_dirt"></i>';
        } else if (dirt_level == 1) {
            return '<i class="fa btn-warning fa-2x fa-trash-o low_dirt"></i>';
        } else {
            return '<i class="fa btn-success fa-check no_dirt"></i>';
        }
    }

    //inicializo konfigurimet e dhomave
    function initRoomConfig() {
        vcroom = $("#vc_room").val();
        roomWidth = roomHeight = $("#width").val();

        //dhoma e cila eshte e ndotur (mund te jene te dyja)
        dirtRoom = $("#dirt_room").val();

        if (dirtRoom == 1) {
            rooma_dirt = $("#dirt_level_a").val();
            console.log("aaa");
        }
        else if (dirtRoom == 2) {
            roomb_dirt = $("#dirt_level_b").val();
            console.log("bbb");
        }
        else if (dirtRoom == 3) {
            rooma_dirt = $("#dirt_level_a").val();
            roomb_dirt = $("#dirt_level_b").val();
            console.log("te dyja");
        }

    }

    function validateForm() {
        form.bootstrapValidator({
            fields: {
                r_width: {
                    validators: {
                        notEmpty: {
                            message: 'Ju lutem plotesoni fushen!'
                        }
                    }
                },
//                r_height: {
//                    validators: {
//                        notEmpty: {
//                            message: 'Ju lutem plotesoni fushen!'
//                        }
//                    }
//                },
                vc_room: {
                    validators: {
                        notEmpty: {
                            message: 'Ju lutem plotesoni fushen!'
                        }
                    }
                },
                dirt_room: {
                    validators: {
                        notEmpty: {
                            message: 'Ju lutem plotesoni fushen!'
                        }
                    }
                }

            }
        }).trigger('submit');
    }

    // hide/show div-et e dhomave kur percaktohet nese jane te ndotura ose jo
    setDirtRoomChangeListener();

    function setDirtRoomChangeListener() {
        $("#dirt_room").change(function () {
            var dirt = $(this).val();

            if (dirt == 3) {
                $(".dirt_level_a_div").addClass('show_this');
                $(".dirt_level_b_div").addClass('show_this');
            }
            else if (dirt == 1) {
                $(".dirt_level_a_div").addClass('show_this');
                $(".dirt_level_a_div").removeClass('hide_this');

                $(".dirt_level_b_div").addClass('hide_this');
                $(".dirt_level_b_div").removeClass('show_this');
            }
            else if (dirt == 2) {
                $(".dirt_level_b_div").addClass('show_this');
                $(".dirt_level_b_div").removeClass('hide_this');

                $(".dirt_level_a_div").addClass("hide_this");
                $(".dirt_level_a_div").removeClass("show_this");
            }
            else {
                $(".dirt_level_b_div").addClass('hide_this');
                $(".dirt_level_b_div").removeClass('show_this');

                $(".dirt_level_a_div").addClass("hide_this");
                $(".dirt_level_a_div").removeClass("show_this");
            }
        });
    }

    //    var cleaned_cells = 0;
    function cleanroom(room, roomSize) {
        var vcPos = VCleaner.currentPos;
        var energy_spent = 0;

        var temp_nearest = parseInt(room.width) + parseInt(room.height);
        var vector = room.dirtVector;
        var cleaned_cells = 0;

        // console.log("vector: ", vector);
        // console.log("vc_pos: " + vcPos);
//        console.log("temp nearest: " + temp_nearest);

        if (room.dirt_rate > 0) {
            VC_Lastpos = VCleaner.vcRoom;

            var i = 0;
            while (vector.length > cleaned_cells) {
                console.log("while ...... ", cleaned_cells);
                console.log("while ...... 1", vector.length);

                var cell_cleaned = -1;
                var temp_energy_spent = 0;

//          Llogaris piken me te afert e cila ndodhet ne vektorin e pikave te pista
                for (var index = 0; index < vector.length; index++) {
//                console.log("for ...... ", index);
//                console.log("for ...... ", $.isArray(vector[index]));
//                console.log("for ...... cl", cleaned_cells);

                    if (vector[index] === true && !$.isArray(vector[index])) {
//                    console.log("vector[index] ", vector[index]);
//                    console.log("isarray ", $.isArray(vector[index]));
//                    console.log("v length 4", vector.length);
//                    console.log("cleaned_cells 3", cleaned_cells);
//                    console.log("continue to clean another cell ..");
                        continue;
                    }

                    var x_real = vector[index][0] - vcPos[0];
                    var y_real = vector[index][1] - vcPos[1];

                    //distanca ne vlere absolute e pikes
                    var x_nearest = Math.abs(x_real);
                    var y_nearest = Math.abs(y_real);

                    if (temp_nearest > (x_nearest + y_nearest)) {

                        temp_nearest = x_nearest + y_nearest;
                        temp_energy_spent = temp_nearest * MOVE_COST;
                        cell_cleaned = index;
                        console.log("Cell potential to be cleaned -> " + vector[index]);
                    }
                    else if (temp_nearest === (x_nearest + y_nearest)) {
                        //nese dy qeliza jane njesoj larg nga VCleaner
                        //zgjedh te leviz te njera prej tyre ne menyre random
                        if (Math.random() * 6 >= 4) {
                            temp_nearest = x_nearest + y_nearest;
                            temp_energy_spent = temp_nearest * MOVE_COST;
                            cell_cleaned = index;
                            console.log("Cell potential to be cleaned  -> " + vector[index]);
                        }
                    }
                }
                temp_nearest = roomSize;
                if (cell_cleaned > -1) {
                    vcPos = updateVCPos(vector[cell_cleaned][0], vector[cell_cleaned][1]);
                    cleaned_cells++;
                    room.clean_route.push({
                        x: vector[cell_cleaned][0],
                        y: vector[cell_cleaned][1]
                    });


//              per pastrimin e nje qelize shpenzon 3 energji
                    temp_energy_spent += CLEAN_CELL;
                    energy_spent += temp_energy_spent;

                    vector[cell_cleaned] = true;
                    console.log("\n ** REZULTATI::\n cleaned at: " + cell_cleaned + "\n curr_VC: [ " + vcPos[0] + " ; " + vcPos[1] + " ] ");
//
//                console.log("\n VC_POS_after:" + vcPos + "\n ENERGY SPENT:" + temp_energy_spent +
//                    "\n TOTAL EN SPENT:" + energy_spent);
//                $.each(vector, function (index, val) {
//                    console.log("vector AFTER clean : " + index + " --> " + val);
//                });
//                console.log("cleaned cell nr: " + getCleandeCellsNr());
                }
                ++i;
                if (i > 200) {
                    break;
                }
            }
        }
        roomCleanedVerctor.push(room.id);

        console.log("rom clean order vector rId: ", room);
        VCleaner.vcRoom = VCleaner.vcRoom == 1 ? 2 :  1;
        VCleaner.vcEnergySpent += energy_spent;
        room.energySpent = energy_spent;
        VCleaner.currentPos = [0, 0];
        handleCleaningOrder();
    }

    function updateVCPos(x, y) {
        VCleaner.currentPos = [x, y];

        return VCleaner.currentPos;
    }

    //inicializon matricat e dhomave
    function initRooms() {
        roomA.width = roomWidth;
        roomA.height = roomWidth;
        roomA.dirt_level = rooma_dirt;
        //inicializo matricen me elelement bosh (dhoma A)
        for (var height = 0; height < roomWidth; height++){
            roomA.matrix[height] = new Array(roomWidth);
        }

        roomB.width = roomWidth;
        roomB.height = roomWidth;
        roomB.dirt_level = roomb_dirt;
        //inicializo matricen me elelement bosh (dhoma B)
        for (var height = 0; height < roomWidth; height++) {
            roomB.matrix[height] = new Array(roomWidth);
        }

        setDirty(roomA, rooma_dirt);
        setDirty(roomB, roomb_dirt);

        VCleaner.vcRoom = vcroom;
        VC_Lastpos = vcroom;
    }

    //i mbush matricen me vlera
    function setDirty(room, dirtlevel) {

        var temp_dirt_rate = 0;
        var vector_index = 0;

        var strMatix = "";
        for (var j = 0; j < room.height; j++) {
            for (var i = 0; i < room.width; i++) {
                var temp_rand = Math.floor(Math.random() * 9) + 1;
                //nese niveli i ndotjes eshte i ulet, gjenerohet me pak vlera '1'
                //perndryshe vlera e qelizes eshte '0'

                if (dirtlevel == 1) {
                    if (temp_rand > 7) {
                        room.matrix[j][i] = 1;
                        strMatix += " - " + room.matrix[j][i];
                        room.dirtVector.push([]);
                        room.dirtVector[vector_index][0] = j;
                        room.dirtVector[vector_index][1] = i;
//                        room.dirtVector[vector_index].push([i, j]);
                        vector_index++;
                        temp_dirt_rate++;
                    } else {
                        room.matrix[j][i] = 0;
                        strMatix += " - " + room.matrix[j][i];
                    }
                }
                else if (dirtlevel == 2) {
                    if (temp_rand > 4) {
                        room.matrix[j][i] = 1;
                        strMatix += " - " + room.matrix[j][i];
                        room.dirtVector.push([]);
                        room.dirtVector[vector_index][0] = j;
                        room.dirtVector[vector_index][1] = i;
                        vector_index++;
                        temp_dirt_rate++;
                    } else {
                        room.matrix[j][i] = 0;
                        strMatix += " - " + room.matrix[j][i];
                    }
                }
                else if (dirtlevel == 0) {
                    room.matrix[j][i] = 0;
//                    console.log('\n e pandotur: ' + room.matrix[j][i]);
                }
            }
            strMatix += "\n";
        }

        room.dirt_rate = parseInt((temp_dirt_rate / (room.width * room.height)) * 100);
    }

    function printoRoom(room, has_vcleaner) {
        var vcleaner = VCleaner;

        matrix_string = "";
        for (var j = 0; j < room.height; j++) {
            matrix_string += "<tr>";
            for (var i = 0; i < room.width; i++) {
                matrix_string += '<td>';
                if (has_vcleaner) {
                    if (vcleaner.currentPos[0] == j && vcleaner.currentPos[1] == i) {
                        matrix_string += '<i class="fa fa-eraser "></i> &nbsp;';
                    }
                }
                if (room.matrix[j][i] === 1) {
                    matrix_string += '<i class="fa fa-eercast"></i></td>';
                } else {
                    matrix_string += '</td>';
                }
            }
            matrix_string += "</tr>";
        }
        return matrix_string;
    }

//    Restart cleaning random
    $("#continue").on('click', function () {
        setCleanBtnListener();
        resetRooms();
        restartCleaning();
    });

    function resetRooms() {
        // roomA ={};
        roomA.matrix =  [[]];
        roomA.width = 0;
        roomA.height = 0;
        roomA.dirtVector = [];
        roomA.dirt_level = 0;
        roomA.dirt_rate = 0;
        roomA.clean_route = [];
        roomA.energySpent = 0;

        // roomB = {};
        roomB.matrix =  [[]];
        roomB.width = 0;
        roomB.height = 0;
        roomB.dirtVector = [];
        roomB.dirt_level = 0;
        roomB.dirt_rate = 0;
        roomB.clean_route = [];
        roomB.energySpent = 0;
        console.log("ROOMA dd",roomA);
        console.log("ROOM B dd", roomB);

    }

    function restartCleaning() {

        oneCleaningCompleted = 0;
        roomCleanedVerctor = [];

        vcroom = Math.floor(Math.random() * 4) +1 > 2 ? 1 : 2;
        VCleaner = {
            currentPos: [0, 0],
            vcRoom: vcroom,
            vcEnergySpent: 0
        };

        console.log("rooma", roomA);
        console.log("roomb", roomB);
        console.log("vcleaner", VCleaner);
        reInitConfig();
        displayRooms();
    }

    function startCleaningROOMS() {
        $("#clean").off('click');
        if (VCleaner.vcRoom == 1) {
            cleanroom(roomA, parseInt(roomA.width) + parseInt(roomA.height));
        } else {
            cleanroom(roomB, parseInt(roomA.width) + parseInt(roomA.height))
        }
    }

    function reInitConfig() {
        //dhoma e cila eshte e ndotur (mund te jene te dyja)
        possibleDirtRoom =  Math.floor(Math.random() * 4) +1 ;
        dirtRoom = possibleDirtRoom - 1;
        // dirtRoom = 1;
        console.log("DIRTt", dirtRoom);

        rooma_dirt = roomb_dirt = 0;

        if (dirtRoom == 1) {
            // niveli i pisllikut te dhoma A
            rooma_dirt = Math.floor(Math.random() * 2) +1;
        }
        else if (dirtRoom == 2) {
            // niveli i pisllikut te dhoma A
            roomb_dirt = Math.floor(Math.random() * 2) +1;
        }
        else if (dirtRoom == 3) {
            console.log("rb RTYUO");

            rooma_dirt = Math.floor(Math.random() * 2) +1;
            roomb_dirt = Math.floor(Math.random() * 2) +1;
        }

        roomA.width = roomA.height = roomWidth;
        roomA.dirt_level = rooma_dirt;
        //inicializo matricen me elelement bosh (dhoma A)
        for (var height = 0; height < roomWidth; height++){
            roomA.matrix[height] = new Array(roomWidth);
        }
        roomB.width = roomB.height = roomWidth;
        roomB.dirt_level = roomb_dirt;

        console.log("ra Dirt", rooma_dirt);
        console.log("rb Dirt", roomb_dirt);
//        return;
        //inicializo matricen me elelement bosh (dhoma B)
        for (var height = 0; height < roomWidth; height++) {
            roomB.matrix[height] = new Array(roomWidth);
        }
        setDirty(roomA, rooma_dirt);
        setDirty(roomB, roomb_dirt);

        console.log("ra:", roomA);
        console.log("rb:", roomB);

        VCleaner.vcRoom = VC_Lastpos;
       console.log("vc LAST pos:",VC_Lastpos);
       console.log("vc_room:",VCleaner.vcRoom);
       console.log("vc_room NExt:",vcroom);
        VC_Lastpos = vcroom;
    }

//    Reset cleaning again
    $("#reconfig").on('click', function () {
        emtyRoomConfigFields();

        setCleanBtnListener();
        room_config_div.removeClass("animate");
        rooms_div.addClass("animate");
        rooms_div.removeClass("animate_show");
        room_cleaning_msg.html('Room configurations ');
        GlobalEnergySpent = 0;
        // room_a_div.html('');
        // room_b_div.html('') ;
        // room_a_dirt_div.html('');
        // room_a_energy_div.html('');
        // room_b_dirt_div.html('');
        // room_b_energy_div.html('');
        // total_energy_spent.html('');
        setCreateRoomListener();
        setDirtRoomChangeListener();
    });

</script>

</body>
</html>

