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
        <h5 class="room_title" style="margin: 24px 0 24px 0;">Room configurations </h5>
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

    <div class="col-md-12" style="text-align: center;">
        <h5 class="room_title" style="margin: 24px 0 0 0;">Room cleaning ... </h5>
        <div class="row">
            <div class="col-md-3 col-md-offset-9">
                <button class="btn btn-default" id="continue">Continue cleaning</button>
                <button class="btn btn-warning" id="reconfig">Config Rooms again</button>
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
                        <p>
                            <i class="fa btn-danger fa-2x fa-trash-o high_dirt"></i>
                            <i class="fa btn-warning  fa-2x fa-trash-o low_dirt"></i>
                            <i class="fa btn-success fa-check no_dirt"></i>
                            &nbsp;&nbsp; <span class="dirt_rate"> 30%</span>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 align-right">
                        <p>Energy Spent: </p>
                    </div>
                    <div class="col-md-6 align-left">
                        <p class="bg_color">
                            <i class="fa btn-danger fa-bolt high_en"></i>
                            <i class="fa btn-info fa-bolt low_en"></i>
                            <i class="fa btn-success fa-check no_en"></i>
                            &nbsp;&nbsp; <span class="energy"> 30</span>
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
                        <p>
                            <i class="fa btn-danger fa-2x fa-trash-o high_dirt"></i>
                            <i class="fa btn-warning fa-2x fa-trash-o low_dirt"></i>
                            <i class="fa btn-success fa-check no_dirt"></i>
                            &nbsp;&nbsp; <span class="dirt_rate"> 24</span>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 align-right">
                        <p>Energy Spent: </p>
                    </div>

                    <div class="col-md-6 align-left">
                        <p>
                            <i class="fa btn-danger fa-bolt high_en"></i>
                            <i class="fa btn-warning fa-bolt low_en"></i>
                            <i class="fa btn-success fa-check no_en"></i>
                            &nbsp;&nbsp; <span class="energy"> 30</span>
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
    var room_a_div = $(".roomA");
    var room_b_div = $(".roomB");

    var oneCleaningCompleted = 0;
    var roomCleanedVerctor = [];

    var MOVE_COST = 1, CLEAN_CELL = 3, CHANGE_ROOM = 2;
    var vcroom = $("#vc_room").val();
    var roomWidth = roomHeight = $("#width").val();
    var dirtRoom = $("#dirt_room").val();
    var rooma_dirt = 0, roomb_dirt = 0;

    //inicializohen dhomat dhe fshesa me verat fillestare te parametrave
    var energySpent = 0;
    var roomA = {
        name: 'roomA',
        id: 1,
        width: 0,
        height: 0,
        matrix: [[]],
        dirtVector: [],
        dirt_level: 0,
        dirt_rate: 0,
        clean_route: []
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
        clean_route: []
    };
    var VCleaner = {
        currentPos: [0, 0],
        vcRoom: vcroom,
        vcEnergySpent: 0
    };

    console.log(VCleaner.vcRoom);
    //klikohet per te krijuar dhomat
    $("#createRoom").on('click', function () {
        if (($("#width").val() > 0) && ($("#vc_room").val() > 0) && ($("#dirt_room").val() > 0)) {
            room_config_div.addClass("animate");
            room_config_div.find(".show_this").removeClass("show_this");

            initRoomConfig();
            initRooms();

            console.log("roma _dirt", roomA.dirt_rate);
            console.log("romb _dirt", roomB.dirt_rate);
            displayRooms();

            if (vcroom == 1) {
                cleanroom(roomA, parseInt(roomA.width) + parseInt(roomA.height));
                // if (roomA.dirt_rate > 0){
                //     showRoute(roomA, 0);
                // }
            } else {
                cleanroom(roomB, parseInt(roomA.width) + parseInt(roomA.height))
                // if (roomB.dirt_rate > 0){
                //     showRoute(roomB, 0);
                // }
            }
        } else {
            validateForm();
        }
    });

    function handleCleaningOrder(){
        console.log("order cleaning called..");

        if(roomCleanedVerctor.length > 1){
            // vizaton pastrimin e dhomave sipas rradhes qe ajo eshte bere
            if(roomCleanedVerctor[0] === roomA.id){
                if (roomA.dirt_rate > 0){
                    showRoute(roomA, 0, roomB);

                    // while(1==1){
                    //     console.log("Cleaning A 1..");
                    //
                    //     // if (finishedCleaning){
                    //         console.log("Cleaning B 1..");
                    //         if (roomB.dirt_rate > 0){
                    //             showRoute(roomB, 0);
                    //         }
                        //     break;
                        // }
                    // }

                }

            }
            else {
                if (roomB.dirt_rate > 0){
                    showRoute(roomB, 0, roomA);

                    // while(1==1){
                        console.log("Cleaning B 2..");
                        // if (finishedCleaning){
                            if (roomA.dirt_rate > 0){
                                console.log("Cleaning A 2..");
                                showRoute(roomA, 0);
                            }
                        //     break;
                        // }
                    // }
                }

            }

            oneCleaningCompleted++;
            roomCleanedVerctor = [];
        }else {
            if (VCleaner.vcRoom == 1) {
                cleanroom(roomA, parseInt(roomA.width) + parseInt(roomA.height));
            } else {
                cleanroom(roomB, parseInt(roomA.width) + parseInt(roomA.height));
            }
        }
    }

    var finishedCleaning = false;

    function showRoute(room, pos, nextRoom) {
        // finishedCleaning = false;
        var cleaned_cell_color = 'green';
        console.log('animating', room.name);
        setTimeout(function () {
            var index = room.clean_route[pos];

            var a = $('table.'+room.name+' tr:nth-child(' + (index.x + 1) + ') td:nth-child('
                        + (index.y + 1) + ')').css('background-color', cleaned_cell_color );

            if (room.clean_route.length > pos + 1) {
                showRoute(room, ++pos, nextRoom)
            }else{
                if(room.id != nextRoom.id){
                    pos = -1;
                    showRoute(nextRoom, ++pos, nextRoom)
                }else{
                    console.log('second room done')
                }
            }
        }, 500);
    }

    function displayRooms() {
        room_a_div.html(printoRoom(roomA, VCleaner.vcRoom == 1));
        room_b_div.html(printoRoom(roomB, VCleaner.vcRoom == 2));
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

        //percakto ku ndodhet fshesa me korrent
        console.log(" dirt room is : " + dirtRoom);
        console.log(" dirt room A  : " + rooma_dirt);
        console.log(" dirt room B  : " + roomb_dirt);
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

    //    var cleaned_cells = 0;
    function cleanroom(room, roomSize) {
        var vcPos = VCleaner.currentPos;
        var energy_spent = 0;

        var temp_nearest = parseInt(room.width) + parseInt(room.height);
        var vector = room.dirtVector;
        var cleaned_cells = 0;

        console.log("vector: ",  vector);
        console.log("vc_pos: " + vcPos);
        console.log("temp nearest: " + temp_nearest);

        while (vector.length > cleaned_cells) {
            console.log("while ...... ", cleaned_cells );

            var cell_cleaned = -1;
            var temp_energy_spent = 0;

//          Llogaris piken me te afert e cila ndodhet ne vektorin e pikave te pista
            for (var index = 0; index < vector.length; index++) {
                console.log("for ...... ", index);
                console.log("for ...... ", $.isArray(vector[index]));
                console.log("for ...... cl", cleaned_cells);

                if (vector[index] === true && !$.isArray(vector[index])) {
                    console.log("vector[index] ", vector[index]);
                    console.log("isarray ", $.isArray(vector[index]));
                    console.log("v length 4", vector.length);
                    console.log("cleaned_cells 3", cleaned_cells);
                    console.log("continue to clean another cell ..");
                    continue;
                }

                var x_real = vector[index][0] - vcPos[0];
                var y_real = vector[index][1] - vcPos[1];

                //distanca ne vlere absolute e pikes
                var x_nearest = Math.abs(x_real);
                var y_nearest = Math.abs(y_real);

                console.log("index", index);
                console.log("vector[index] ", vector[index]);

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
                VCleaner.vcEnergySpent = energy_spent;

                vector[cell_cleaned] = true;
                console.log("\n ** REZULTATI::\n cleaned at: " + cell_cleaned + "\n curr_VC: [ " + vcPos[0] + " ; " + vcPos[1] + " ] ");

                console.log("\n VC_POS_after:" + vcPos + "\n ENERGY SPENT:" + temp_energy_spent +
                    "\n TOTAL EN SPENT:" + energy_spent);
                $.each(vector, function (index, val) {
                    console.log("vector AFTER clean : " + index + " --> " + val);
                });
//                console.log("cleaned cell nr: " + getCleandeCellsNr());
            }

        }

        roomCleanedVerctor.push(room.id);
        console.log("rom clean ored vector: ", roomCleanedVerctor);
        VCleaner.vcRoom == 1 ? VCleaner.vcRoom = 2 : VCleaner.vcRoom = 1;
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
        for (var height = 0; height < roomWidth; height++) {
            roomA.matrix[height] = new Array(roomWidth);
        }

        roomB.width = roomWidth;
        roomB.height = roomWidth;
        roomB.dirt_level = roomb_dirt;
        //inicializo matricen me elelement bosh (dhoma B)
        for (var height = 0; height < roomWidth; height++) {
            roomB.matrix[height] = new Array(roomWidth);
        }

        console.log("dh A matrix:" + roomA.matrix);
        console.log("dh B matrix:" + roomB.matrix);
        console.log("VCleaner pos: " + VCleaner.currentPos);
        console.log("VCleaner energy: " + VCleaner.vcEnergySpent);
        console.log("VCleaner room: " + VCleaner.vcRoom);
        setDirty(roomA, rooma_dirt);
        setDirty(roomB, roomb_dirt);

        VCleaner.vcRoom = vcroom;
    }

    //i mbush matricen me vlera
    function setDirty(room, dirtlevel) {

        var temp_dirt_rate = 0;
        var vector_index = 0;

        console.log("room " + room.name);
        console.log("Height: " + room.height);
        console.log("Width: " + room.width);
        console.log("Dirt: " + dirtlevel);

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
                    console.log('\n e pandotur: ' + room.matrix[j][i]);
                }

                //krijon nje vektor me koordinatat e qelizave te papastra
            }
            strMatix += "\n";
        }

        $.each(room.dirtVector, function (index, val) {
            console.log("qeliza pis :" + val);
        });

        console.log("MATRICA :\n" + strMatix);

        room.dirt_rate = parseInt((temp_dirt_rate / (room.width * room.height)) * 100);
        console.log("DIRT_ RATE :\n" + room.dirt_rate);

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

</script>

</body>
</html>

