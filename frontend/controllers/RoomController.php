<?php
require_once 'models/Room.php';

$action = $_GET['action'] ?? 'listPage';

switch ($action) {
    case 'listPage':
        $page = isset($_GET['page']) ? max(0, intval($_GET['page']) - 1) : 0;
        $size = isset($_GET['size']) ? intval($_GET['size']) : 10;
        try {
            $rooms = Room::getAllPaged($page, $size);
            require_once 'views/room/list_room_page.php';
        } catch (Exception $e) {
            $error = "Không thể tải danh sách phòng khám: " . $e->getMessage();
            require_once 'views/room/list_room_page.php';
        }
        break;

    case 'createPage':
        try {
            require_once 'views/room/create_room_page.php';
        } catch (Exception $e) {
            $error = "Không thể tải trang tạo phòng khám.";
            require_once 'views/room/create_room_page.php';
        }
        break;

    case 'create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            try {
                Room::createRoom($data);
                header("Location: index.php?controller=Room&action=listPage");
                exit();
            } catch (Exception $e) {
                $error = "Tạo phòng khám thất bại: " . $e->getMessage();
                require_once 'views/room/create_room_page.php';
            }
        }
        break;

    case 'updatePage':
        $id = $_GET['id'] ?? '';
        try {
            $room = Room::getRoomById($id);
            require_once 'views/room/update_room_page.php';
        } catch (Exception $e) {
            $error = "Không thể tải thông tin phòng khám.";
            require_once 'views/room/update_room_page.php';
        }
        break;

    case 'update':
        $id = $_GET['id'] ?? '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            try {
                Room::updateRoom($id, $data);
                header("Location: index.php?controller=Room&action=listPage");
                exit();
            } catch (Exception $e) {
                $error = "Cập nhật phòng khám thất bại: " . $e->getMessage();
                $room = $data;
                require_once 'views/room/update_room_page.php';
            }
        }
        break;

    case 'delete':
        $id = $_GET['id'] ?? '';
        try {
            Room::deleteRoom($id);
            header("Location: index.php?controller=Room&action=listPage");
            exit();
        } catch (Exception $e) {
            $error = "Xóa phòng khám thất bại: " . $e->getMessage();
            $page = 0;
            $size = 10;
            $rooms = Room::getAllPaged($page, $size);
            require_once 'views/room/list_room_page.php';
        }
        break;

    case 'getAll':
        try {
            $rooms = Room::getAll();
            header('Content-Type: application/json');
            echo json_encode($rooms);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(["error" => "Không thể lấy danh sách phòng khám."]);
        }
        break;

    default:
        http_response_code(404);
        echo "Không tìm thấy chức năng yêu cầu.";
        break;
}
