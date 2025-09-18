        <div class="text-center my-5">
            <div class="d-flex justify-content-center">
                <img id="tuneArt" class="art-file text-center" src="">
            </div>
            <h2 class="my-2" class="fs-2">
                <span id="tuneTitle"></span>
            </h2>
            <h3 class="fs-5">
                <span id="tuneArtist"></span>
            </h3>
            <h4 class="my-2 fs-5">
                <span>
                    <span id="tuneNowTime"></span>
                </span>
                <span>　/　</span>
                <span>
                    <span id="tuneTotalTime"></span>
                </span>
            </h4>

  <script>
    // SSEでのJSONデータ受取りから表示
    document.addEventListener('DOMContentLoaded', () => {
        const es = new EventSource('./playingDataAcess.php');

        es.onmessage = function(event) {
            if (!event.data) return;
            // Jsonデータ取り出し            
            const obj = JSON.parse(event.data);

            // 文字列のまま表示
            document.getElementById("tuneTitle").innerText = obj.tuneTitle || '';
            document.getElementById("tuneArtist").innerText = obj.tuneArtist || '';
            document.getElementById("tuneNowTime").innerText = obj.tuneNowTime || '';
            document.getElementById("tuneTotalTime").innerText = obj.tuneTotalTime || '';

            // Base64画像を表示
            const artFile = document.getElementById("tuneArt");
            if (obj.tuneArt) {
                // MIMEタイプ付きでアートファイルを組み立て
                const mimeType = obj.mimeType || "image/jpeg";
                artFile.src = `data:${mimeType};base64,${obj.tuneArt}`;
                artFile.style.display = 'block';
            } else {
                artFile.style.display = 'none';
            }

        };
    });
  </script>
        </div>