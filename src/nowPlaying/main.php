        <div class="text-center my-5">
            <div>
                <img id="tuneArt" class="art-file" src="">
            </div>
            <h2 class="my-2">
                <span id="tuneTitle"></span>
            </h2>
            <h3>
                <span id="tuneArtist"></span>
            </h3>
            <h4 class="my-2">
                <span>
                    <span id="tuneNowTime"></span>
                </span>
                <span> / </span>
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
            
            const obj = JSON.parse(event.data);

            // 文字列のまま表示
            document.getElementById("tuneTitle").innerText = obj.tuneTitle || '';
            document.getElementById("tuneArtist").innerText = obj.tuneArtist || '';
            document.getElementById("tuneArt").src = obj.tuneArtFile || '';
            document.getElementById("tuneNowTime").innerText = obj.tuneNowTime || '';
            document.getElementById("tuneTotalTime").innerText = obj.tuneTotalTime || '';
        };
    });
  </script>
        </div>