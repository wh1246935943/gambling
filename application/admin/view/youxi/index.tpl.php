{include file="public/toper" /}
<style>
.layui-form-select{
	width: 35%;
    float: inherit;
}
.layui-form-label {
    width: 120px;
}
</style>
<div class="layui-tab layui-tab-brief main-tab-container">
        <div class="layui-tab-item layui-show">
            <blockquote class="layui-elem-quote">游戏设置</blockquote>
            <form class="layui-form" method="post">
                <div class="layui-form-item">
                    <div class="layui-input-block" style="margin-left: 0;font-size: 1rem;">
                        <div class="suiji">
                            {volist name="list" id="v"}
                            <blockquote class="layui-elem-quote quote_{$v['id']}"   onclick="showCon('{$v['id']}')" style="border-left: 0px;width: 5rem;float: left;margin-right:.5rem;text-align: center">{$v['name']}</blockquote>
                            {/volist}
                            {volist name="list" id="v" key="k"}
                            {if $k!=1}
                            <div style="width: 100%;display: none" id="{$v['id']}">
                            {else}
                            <div style="width: 100%;" id="{$v['id']}">
                            {/if}
                                    <div class="layui-form-item" >
                                        <label class="layui-form-label">每天开始时间</label>
                                        <div class="layui-input-inline">
                                            <select name="date[{$v['id']}][start_time]" lay-verify="required">
                                                <option value="0" {eq name="v['start_time']" value="0"} selected="selected" {/eq} >00</option>
                                                <option value="1" {eq name="v['start_time']" value="1"} selected="selected" {/eq} >01</option>
                                                <option value="2" {eq name="v['start_time']" value="2"} selected="selected" {/eq} >02</option>
                                                <option value="3" {eq name="v['start_time']" value="3"} selected="selected" {/eq} >03</option>
                                                <option value="4" {eq name="v['start_time']" value="4"} selected="selected" {/eq} >04</option>
                                                <option value="5" {eq name="v['start_time']" value="5"} selected="selected" {/eq} >05</option>
                                                <option value="6" {eq name="v['start_time']" value="6"} selected="selected" {/eq} >06</option>
                                                <option value="7" {eq name="v['start_time']" value="7"} selected="selected" {/eq} >07</option>
                                                <option value="8" {eq name="v['start_time']" value="8"} selected="selected" {/eq} >08</option>
                                                <option value="9" {eq name="v['start_time']" value="9"} selected="selected" {/eq} >09</option>
                                                <option value="10" {eq name="v['start_time']" value="10"} selected="selected" {/eq} >10</option>
                                                <option value="11" {eq name="v['start_time']" value="11"} selected="selected" {/eq} >11</option>
                                                <option value="12" {eq name="v['start_time']" value="12"} selected="selected" {/eq} >12</option>
                                                <option value="13" {eq name="v['start_time']" value="13"} selected="selected" {/eq} >13</option>
                                                <option value="14" {eq name="v['start_time']" value="14"} selected="selected" {/eq} >14</option>
                                                <option value="15" {eq name="v['start_time']" value="15"} selected="selected" {/eq} >15</option>
                                                <option value="16" {eq name="v['start_time']" value="16"} selected="selected" {/eq} >16</option>
                                                <option value="17" {eq name="v['start_time']" value="17"} selected="selected" {/eq} >17</option>
                                                <option value="18" {eq name="v['start_time']" value="18"} selected="selected" {/eq} >18</option>
                                                <option value="19" {eq name="v['start_time']" value="19"} selected="selected" {/eq} >19</option>
                                                <option value="20" {eq name="v['start_time']" value="20"} selected="selected" {/eq} >20</option>
                                                <option value="21" {eq name="v['start_time']" value="21"} selected="selected" {/eq} >21</option>
                                                <option value="22" {eq name="v['start_time']" value="22"} selected="selected" {/eq} >22</option>
                                                <option value="23" {eq name="v['start_time']" value="23"} selected="selected" {/eq} >23</option>
                                                <option value="24" {eq name="v['start_time']" value="24"} selected="selected" {/eq} >24</option>
                                              </select>
											  <select name="date[{$v['id']}][start_time_minute]" lay-verify="required">
                                                <option value="0" {eq name="v['start_time_minute']" value="0"} selected="selected" {/eq} >00</option>
                                                <option value="1" {eq name="v['start_time_minute']" value="1"} selected="selected" {/eq} >01</option>
                                                <option value="2" {eq name="v['start_time_minute']" value="2"} selected="selected" {/eq} >02</option>
                                                <option value="3" {eq name="v['start_time_minute']" value="3"} selected="selected" {/eq} >03</option>
                                                <option value="4" {eq name="v['start_time_minute']" value="4"} selected="selected" {/eq} >04</option>
                                                <option value="5" {eq name="v['start_time_minute']" value="5"} selected="selected" {/eq} >05</option>
                                                <option value="6" {eq name="v['start_time_minute']" value="6"} selected="selected" {/eq} >06</option>
                                                <option value="7" {eq name="v['start_time_minute']" value="7"} selected="selected" {/eq} >07</option>
                                                <option value="8" {eq name="v['start_time_minute']" value="8"} selected="selected" {/eq} >08</option>
                                                <option value="9" {eq name="v['start_time_minute']" value="9"} selected="selected" {/eq} >09</option>
                                                <option value="10" {eq name="v['start_time_minute']" value="10"} selected="selected" {/eq} >10</option>
                                                <option value="11" {eq name="v['start_time_minute']" value="11"} selected="selected" {/eq} >11</option>
                                                <option value="12" {eq name="v['start_time_minute']" value="12"} selected="selected" {/eq} >12</option>
                                                <option value="13" {eq name="v['start_time_minute']" value="13"} selected="selected" {/eq} >13</option>
                                                <option value="14" {eq name="v['start_time_minute']" value="14"} selected="selected" {/eq} >14</option>
                                                <option value="15" {eq name="v['start_time_minute']" value="15"} selected="selected" {/eq} >15</option>
                                                <option value="16" {eq name="v['start_time_minute']" value="16"} selected="selected" {/eq} >16</option>
                                                <option value="17" {eq name="v['start_time_minute']" value="17"} selected="selected" {/eq} >17</option>
                                                <option value="18" {eq name="v['start_time_minute']" value="18"} selected="selected" {/eq} >18</option>
                                                <option value="19" {eq name="v['start_time_minute']" value="19"} selected="selected" {/eq} >19</option>
                                                <option value="20" {eq name="v['start_time_minute']" value="20"} selected="selected" {/eq} >20</option>
                                                <option value="21" {eq name="v['start_time_minute']" value="21"} selected="selected" {/eq} >21</option>
                                                <option value="22" {eq name="v['start_time_minute']" value="22"} selected="selected" {/eq} >22</option>
                                                <option value="23" {eq name="v['start_time_minute']" value="23"} selected="selected" {/eq} >23</option>
                                                <option value="24" {eq name="v['start_time_minute']" value="24"} selected="selected" {/eq} >24</option>
												<option value="25" {eq name="v['start_time_minute']" value="25"} selected="selected" {/eq} >25</option>
                                                <option value="26" {eq name="v['start_time_minute']" value="26"} selected="selected" {/eq} >26</option>
                                                <option value="27" {eq name="v['start_time_minute']" value="27"} selected="selected" {/eq} >27</option>
                                                <option value="28" {eq name="v['start_time_minute']" value="28"} selected="selected" {/eq} >28</option>
                                                <option value="29" {eq name="v['start_time_minute']" value="29"} selected="selected" {/eq} >29</option>
                                                <option value="30" {eq name="v['start_time_minute']" value="30"} selected="selected" {/eq} >30</option>
                                                <option value="31" {eq name="v['start_time_minute']" value="31"} selected="selected" {/eq} >31</option>
                                                <option value="32" {eq name="v['start_time_minute']" value="32"} selected="selected" {/eq} >32</option>
                                                <option value="33" {eq name="v['start_time_minute']" value="33"} selected="selected" {/eq} >33</option>
                                                <option value="34" {eq name="v['start_time_minute']" value="34"} selected="selected" {/eq} >34</option>
                                                <option value="35" {eq name="v['start_time_minute']" value="35"} selected="selected" {/eq} >35</option>
                                                <option value="36" {eq name="v['start_time_minute']" value="36"} selected="selected" {/eq} >36</option>
                                                <option value="37" {eq name="v['start_time_minute']" value="37"} selected="selected" {/eq} >37</option>
                                                <option value="38" {eq name="v['start_time_minute']" value="38"} selected="selected" {/eq} >38</option>
                                                <option value="39" {eq name="v['start_time_minute']" value="39"} selected="selected" {/eq} >39</option>
                                                <option value="40" {eq name="v['start_time_minute']" value="40"} selected="selected" {/eq} >40</option>
                                                <option value="41" {eq name="v['start_time_minute']" value="41"} selected="selected" {/eq} >41</option>
                                                <option value="42" {eq name="v['start_time_minute']" value="42"} selected="selected" {/eq} >42</option>
                                                <option value="43" {eq name="v['start_time_minute']" value="43"} selected="selected" {/eq} >43</option>
                                                <option value="44" {eq name="v['start_time_minute']" value="44"} selected="selected" {/eq} >44</option>
                                                <option value="45" {eq name="v['start_time_minute']" value="45"} selected="selected" {/eq} >45</option>
                                                <option value="46" {eq name="v['start_time_minute']" value="46"} selected="selected" {/eq} >46</option>
                                                <option value="47" {eq name="v['start_time_minute']" value="47"} selected="selected" {/eq} >47</option>
                                                <option value="48" {eq name="v['start_time_minute']" value="48"} selected="selected" {/eq} >48</option>
                                                <option value="49" {eq name="v['start_time_minute']" value="49"} selected="selected" {/eq} >49</option>
												<option value="50" {eq name="v['start_time_minute']" value="50"} selected="selected" {/eq} >50</option>
                                                <option value="51" {eq name="v['start_time_minute']" value="51"} selected="selected" {/eq} >51</option>
                                                <option value="52" {eq name="v['start_time_minute']" value="52"} selected="selected" {/eq} >52</option>
                                                <option value="53" {eq name="v['start_time_minute']" value="53"} selected="selected" {/eq} >53</option>
                                                <option value="54" {eq name="v['start_time_minute']" value="54"} selected="selected" {/eq} >54</option>
                                                <option value="55" {eq name="v['start_time_minute']" value="55"} selected="selected" {/eq} >55</option>
                                                <option value="56" {eq name="v['start_time_minute']" value="56"} selected="selected" {/eq} >56</option>
                                                <option value="57" {eq name="v['start_time_minute']" value="57"} selected="selected" {/eq} >57</option>
                                                <option value="58" {eq name="v['start_time_minute']" value="58"} selected="selected" {/eq} >58</option>
                                                <option value="59" {eq name="v['start_time_minute']" value="59"} selected="selected" {/eq} >59</option>
                                              </select>
                                        </div>
                                        <label class="layui-form-label">每天结束时间</label>
                                        <div class="layui-input-inline">
                                            <select name="date[{$v['id']}][end_time]" lay-verify="required">
                                                <option value="0" {eq name="v['end_time']" value="0"} selected="selected" {/eq} >00</option>
                                                <option value="1" {eq name="v['end_time']" value="1"} selected="selected" {/eq} >01</option>
                                                <option value="2" {eq name="v['end_time']" value="2"} selected="selected" {/eq} >02</option>
                                                <option value="3" {eq name="v['end_time']" value="3"} selected="selected" {/eq} >03</option>
                                                <option value="4" {eq name="v['end_time']" value="4"} selected="selected" {/eq} >04</option>
                                                <option value="5" {eq name="v['end_time']" value="5"} selected="selected" {/eq} >05</option>
                                                <option value="6" {eq name="v['end_time']" value="6"} selected="selected" {/eq} >06</option>
                                                <option value="7" {eq name="v['end_time']" value="7"} selected="selected" {/eq} >07</option>
                                                <option value="8" {eq name="v['end_time']" value="8"} selected="selected" {/eq} >08</option>
                                                <option value="9" {eq name="v['end_time']" value="9"} selected="selected" {/eq} >09</option>
                                                <option value="10" {eq name="v['end_time']" value="10"} selected="selected" {/eq} >10</option>
                                                <option value="11" {eq name="v['end_time']" value="11"} selected="selected" {/eq} >11</option>
                                                <option value="12" {eq name="v['end_time']" value="12"} selected="selected" {/eq} >12</option>
                                                <option value="13" {eq name="v['end_time']" value="13"} selected="selected" {/eq} >13</option>
                                                <option value="14" {eq name="v['end_time']" value="14"} selected="selected" {/eq} >14</option>
                                                <option value="15" {eq name="v['end_time']" value="15"} selected="selected" {/eq} >15</option>
                                                <option value="16" {eq name="v['end_time']" value="16"} selected="selected" {/eq} >16</option>
                                                <option value="17" {eq name="v['end_time']" value="17"} selected="selected" {/eq} >17</option>
                                                <option value="18" {eq name="v['end_time']" value="18"} selected="selected" {/eq} >18</option>
                                                <option value="19" {eq name="v['end_time']" value="19"} selected="selected" {/eq} >19</option>
                                                <option value="20" {eq name="v['end_time']" value="20"} selected="selected" {/eq} >20</option>
                                                <option value="21" {eq name="v['end_time']" value="21"} selected="selected" {/eq} >21</option>
                                                <option value="22" {eq name="v['end_time']" value="22"} selected="selected" {/eq} >22</option>
                                                <option value="23" {eq name="v['end_time']" value="23"} selected="selected" {/eq} >23</option>
                                                <option value="24" {eq name="v['end_time']" value="24"} selected="selected" {/eq} >24</option>
                                            </select>
                                            <select name="date[{$v['id']}][end_time_minute]" lay-verify="required">
                                                <option value="0" {eq name="v['end_time_minute']" value="0"} selected="selected" {/eq} >00</option>
                                                <option value="1" {eq name="v['end_time_minute']" value="1"} selected="selected" {/eq} >01</option>
                                                <option value="2" {eq name="v['end_time_minute']" value="2"} selected="selected" {/eq} >02</option>
                                                <option value="3" {eq name="v['end_time_minute']" value="3"} selected="selected" {/eq} >03</option>
                                                <option value="4" {eq name="v['end_time_minute']" value="4"} selected="selected" {/eq} >04</option>
                                                <option value="5" {eq name="v['end_time_minute']" value="5"} selected="selected" {/eq} >05</option>
                                                <option value="6" {eq name="v['end_time_minute']" value="6"} selected="selected" {/eq} >06</option>
                                                <option value="7" {eq name="v['end_time_minute']" value="7"} selected="selected" {/eq} >07</option>
                                                <option value="8" {eq name="v['end_time_minute']" value="8"} selected="selected" {/eq} >08</option>
                                                <option value="9" {eq name="v['end_time_minute']" value="9"} selected="selected" {/eq} >09</option>
                                                <option value="10" {eq name="v['end_time_minute']" value="10"} selected="selected" {/eq} >10</option>
                                                <option value="11" {eq name="v['end_time_minute']" value="11"} selected="selected" {/eq} >11</option>
                                                <option value="12" {eq name="v['end_time_minute']" value="12"} selected="selected" {/eq} >12</option>
                                                <option value="13" {eq name="v['end_time_minute']" value="13"} selected="selected" {/eq} >13</option>
                                                <option value="14" {eq name="v['end_time_minute']" value="14"} selected="selected" {/eq} >14</option>
                                                <option value="15" {eq name="v['end_time_minute']" value="15"} selected="selected" {/eq} >15</option>
                                                <option value="16" {eq name="v['end_time_minute']" value="16"} selected="selected" {/eq} >16</option>
                                                <option value="17" {eq name="v['end_time_minute']" value="17"} selected="selected" {/eq} >17</option>
                                                <option value="18" {eq name="v['end_time_minute']" value="18"} selected="selected" {/eq} >18</option>
                                                <option value="19" {eq name="v['end_time_minute']" value="19"} selected="selected" {/eq} >19</option>
                                                <option value="20" {eq name="v['end_time_minute']" value="20"} selected="selected" {/eq} >20</option>
                                                <option value="21" {eq name="v['end_time_minute']" value="21"} selected="selected" {/eq} >21</option>
                                                <option value="22" {eq name="v['end_time_minute']" value="22"} selected="selected" {/eq} >22</option>
                                                <option value="23" {eq name="v['end_time_minute']" value="23"} selected="selected" {/eq} >23</option>
                                                <option value="24" {eq name="v['end_time_minute']" value="24"} selected="selected" {/eq} >24</option>
                                                <option value="25" {eq name="v['end_time_minute']" value="25"} selected="selected" {/eq} >25</option>
                                                <option value="26" {eq name="v['end_time_minute']" value="26"} selected="selected" {/eq} >26</option>
                                                <option value="27" {eq name="v['end_time_minute']" value="27"} selected="selected" {/eq} >27</option>
                                                <option value="28" {eq name="v['end_time_minute']" value="28"} selected="selected" {/eq} >28</option>
                                                <option value="29" {eq name="v['end_time_minute']" value="29"} selected="selected" {/eq} >29</option>
                                                <option value="30" {eq name="v['end_time_minute']" value="30"} selected="selected" {/eq} >30</option>
                                                <option value="31" {eq name="v['end_time_minute']" value="31"} selected="selected" {/eq} >31</option>
                                                <option value="32" {eq name="v['end_time_minute']" value="32"} selected="selected" {/eq} >32</option>
                                                <option value="33" {eq name="v['end_time_minute']" value="33"} selected="selected" {/eq} >33</option>
                                                <option value="34" {eq name="v['end_time_minute']" value="34"} selected="selected" {/eq} >34</option>
                                                <option value="35" {eq name="v['end_time_minute']" value="35"} selected="selected" {/eq} >35</option>
                                                <option value="36" {eq name="v['end_time_minute']" value="36"} selected="selected" {/eq} >36</option>
                                                <option value="37" {eq name="v['end_time_minute']" value="37"} selected="selected" {/eq} >37</option>
                                                <option value="38" {eq name="v['end_time_minute']" value="38"} selected="selected" {/eq} >38</option>
                                                <option value="39" {eq name="v['end_time_minute']" value="39"} selected="selected" {/eq} >39</option>
                                                <option value="40" {eq name="v['end_time_minute']" value="40"} selected="selected" {/eq} >40</option>
                                                <option value="41" {eq name="v['end_time_minute']" value="41"} selected="selected" {/eq} >41</option>
                                                <option value="42" {eq name="v['end_time_minute']" value="42"} selected="selected" {/eq} >42</option>
                                                <option value="43" {eq name="v['end_time_minute']" value="43"} selected="selected" {/eq} >43</option>
                                                <option value="44" {eq name="v['end_time_minute']" value="44"} selected="selected" {/eq} >44</option>
                                                <option value="45" {eq name="v['end_time_minute']" value="45"} selected="selected" {/eq} >45</option>
                                                <option value="46" {eq name="v['end_time_minute']" value="46"} selected="selected" {/eq} >46</option>
                                                <option value="47" {eq name="v['end_time_minute']" value="47"} selected="selected" {/eq} >47</option>
                                                <option value="48" {eq name="v['end_time_minute']" value="48"} selected="selected" {/eq} >48</option>
                                                <option value="49" {eq name="v['end_time_minute']" value="49"} selected="selected" {/eq} >49</option>
                                                <option value="50" {eq name="v['end_time_minute']" value="50"} selected="selected" {/eq} >50</option>
                                                <option value="51" {eq name="v['end_time_minute']" value="51"} selected="selected" {/eq} >51</option>
                                                <option value="52" {eq name="v['end_time_minute']" value="52"} selected="selected" {/eq} >52</option>
                                                <option value="53" {eq name="v['end_time_minute']" value="53"} selected="selected" {/eq} >53</option>
                                                <option value="54" {eq name="v['end_time_minute']" value="54"} selected="selected" {/eq} >54</option>
                                                <option value="55" {eq name="v['end_time_minute']" value="55"} selected="selected" {/eq} >55</option>
                                                <option value="56" {eq name="v['end_time_minute']" value="56"} selected="selected" {/eq} >56</option>
                                                <option value="57" {eq name="v['end_time_minute']" value="57"} selected="selected" {/eq} >57</option>
                                                <option value="58" {eq name="v['end_time_minute']" value="58"} selected="selected" {/eq} >58</option>
                                                <option value="59" {eq name="v['end_time_minute']" value="59"} selected="selected" {/eq} >59</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">开盘延迟秒数</label>
                                        <div class="layui-input-inline">
                                            <input type="number" name="date[{$v['id']}][qs_start_time]" required lay-verify="num" value="{$v['qs_start_time']}" placeholder="计时单位为秒" autocomplete="off" class="layui-input">
                                        </div>
                                        <label class="layui-form-label">封盘提前秒数</label>
                                        <div class="layui-input-inline">
                                            <input type="number" name="date[{$v['id']}][qs_end_time]" required lay-verify="num" value="{$v['qs_end_time']}" placeholder="计时单位为秒" autocomplete="off" class="layui-input">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">维护提示语</label>
                                        <div class="layui-input-inline">
                                            <textarea name="date[{$v['id']}][weihu_prompt]" placeholder="<br>表示换行"  rows="6" cols="70">{$v['weihu_prompt']}</textarea>
                                        </div>
                                    </div>
									<div class="layui-form-item">
                                        <label class="layui-form-label">开盘提示语</label>
                                        <div class="layui-input-inline">
                                            <textarea name="date[{$v['id']}][qs_start_prompt]" placeholder="<br>表示换行" lay-verify="prompt" rows="6" cols="70">{$v['qs_start_prompt']}</textarea>
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">封盘提前30秒提示语</label>
                                        <div class="layui-input-inline">
                                            <textarea name="date[{$v['id']}][qs_end_prompt]" lay-verify="prompt" placeholder="<br>表示换行" rows="6" cols="70">{$v['qs_end_prompt']}</textarea>
                                        </div>
                                    </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label">封盘广告语</label>
                                    <div class="layui-input-inline" style='width: 550px;'>
                                        <textarea name="date[{$v['id']}][qs_end_gg]"  placeholder="<br>表示换行" rows="6" cols="70">{$v['qs_end_gg']}</textarea>
                                    </div>
                                </div>

				                <div class="layui-form-item">
                                    <label class="layui-form-label">前台标题</label>
                                    <div class="layui-input-inline" style='width: 550px;'>
                                        <input type="text" name="date[{$v['id']}][title]" required lay-verify="prompt" value="{$v['title']}" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                                {if $v['type']=='bjsc' || $v['type']=='xyft'}
                                <div class="layui-form-item">
                                    <label class="layui-form-label">游戏介绍</label>
                                    <div class="layui-input-inline" style='width: 550px;'>
                                        <textarea name="date[{$v['id']}][game_js]" placeholder="<br>表示换行" rows="6" cols="70">{$v['game_js']}</textarea>
                                    </div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label">游戏资料</label>
                                    <div class="layui-input-inline" style='width: 550px;'>
                                        <textarea name="date[{$v['id']}][game_zl]" placeholder="<br>表示换行"  rows="6" cols="70">{$v['game_zl']}</textarea>
                                    </div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label">游戏玩法</label>
                                    <div class="layui-input-inline" style='width: 550px;'>
                                        <textarea name="date[{$v['id']}][game_wf]" placeholder="<br>表示换行" rows="6" cols="70">{$v['game_wf']}</textarea>
                                    </div>
                                </div>
                                {else}
                                <div class="layui-form-item">
                                    <label class="layui-form-label">房间一名称</label>
                                    <div class="layui-input-inline" style='width: 550px;'>
                                        <input type="text" name="date[{$v['id']}][one_room_name]" required value="{$v['one_room_name']}" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">房间一在线人数范围</label>
                                    <div class="layui-input-inline" >
                                        <input type="text" name="date[{$v['id']}][one_zxrs][0]" required value="<?php echo explode(',',$v['one_zxrs'])[0] ?>" placeholder="在线人数最小范围" autocomplete="off" class="layui-input">
                                    </div>
                                    <div class="layui-input-inline">
                                        <input type="text" name="date[{$v['id']}][one_zxrs][1]" required value="<?php echo explode(',',$v['one_zxrs'])[1] ?>" placeholder="在线人数最大范围" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">房间一机器人大小单双投注范围</label>
                                    <div class="layui-input-inline" >
                                        <input type="text" name="date[{$v['id']}][one_dxds][0]" required value="<?php echo explode(',',$v['one_dxds'])[0] ?>" placeholder="大小单双金额最小范围" autocomplete="off" class="layui-input">
                                    </div>
                                    <div class="layui-input-inline">
                                        <input type="text" name="date[{$v['id']}][one_dxds][1]" required value="<?php echo explode(',',$v['one_dxds'])[1] ?>" placeholder="大小单双金额最大范围" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">房间一机器人0-27投注范围</label>
                                    <div class="layui-input-inline" >
                                        <input type="text" name="date[{$v['id']}][one_zesev][0]" required value="<?php echo explode(',',$v['one_zesev'])[0] ?>" placeholder="0-27金额最小范围" autocomplete="off" class="layui-input">
                                    </div>
                                    <div class="layui-input-inline">
                                        <input type="text" name="date[{$v['id']}][one_zesev][1]" required value="<?php echo explode(',',$v['one_zesev'])[1] ?>" placeholder="0-27金额最大范围" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">房间一机器人极对豹顺投注范围</label>
                                    <div class="layui-input-inline" >
                                        <input type="text" name="date[{$v['id']}][one_jdbs][0]" required value="<?php echo explode(',',$v['one_jdbs'])[0] ?>" placeholder="极对豹顺金额最小范围" autocomplete="off" class="layui-input">
                                    </div>
                                    <div class="layui-input-inline">
                                        <input type="text" name="date[{$v['id']}][one_jdbs][1]" required value="<?php echo explode(',',$v['one_jdbs'])[1] ?>" placeholder="极对豹顺金额最大范围" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                                {if $v['type']=='pc28' || $v['type']=='jld28' || $v['type']=='az28'}
                                <div class="layui-form-item">
                                    <label class="layui-form-label">房间二名称</label>
                                    <div class="layui-input-inline" style='width: 550px;'>
                                        <input type="text" name="date[{$v['id']}][two_room_name]" required value="{$v['two_room_name']}" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">房间二在线人数范围</label>
                                    <div class="layui-input-inline" >
                                        <input type="text" name="date[{$v['id']}][two_zxrs][0]" required value="<?php echo explode(',',$v['two_zxrs'])[0] ?>" placeholder="在线人数最小范围" autocomplete="off" class="layui-input">
                                    </div>
                                    <div class="layui-input-inline">
                                        <input type="text" name="date[{$v['id']}][two_zxrs][1]" required value="<?php echo explode(',',$v['two_zxrs'])[1] ?>" placeholder="在线人数最大范围" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">房间二机器人大小单双投注范围</label>
                                    <div class="layui-input-inline" >
                                        <input type="text" name="date[{$v['id']}][two_dxds][0]" required value="<?php echo explode(',',$v['two_dxds'])[0] ?>" placeholder="大小单双金额最小范围" autocomplete="off" class="layui-input">
                                    </div>
                                    <div class="layui-input-inline">
                                        <input type="text" name="date[{$v['id']}][two_dxds][1]" required value="<?php echo explode(',',$v['two_dxds'])[1] ?>" placeholder="大小单双金额最大范围" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">房间二机器人0-27投注范围</label>
                                    <div class="layui-input-inline" >
                                        <input type="text" name="date[{$v['id']}][two_zesev][0]" required value="<?php echo explode(',',$v['two_zesev'])[0] ?>" placeholder="0-27金额最小范围" autocomplete="off" class="layui-input">
                                    </div>
                                    <div class="layui-input-inline">
                                        <input type="text" name="date[{$v['id']}][two_zesev][1]" required value="<?php echo explode(',',$v['two_zesev'])[1] ?>" placeholder="0-27金额最大范围" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">房间二机器人极对豹顺投注范围</label>
                                    <div class="layui-input-inline" >
                                        <input type="text" name="date[{$v['id']}][two_jdbs][0]" required value="<?php echo explode(',',$v['two_jdbs'])[0] ?>" placeholder="极对豹顺金额最小范围" autocomplete="off" class="layui-input">
                                    </div>
                                    <div class="layui-input-inline">
                                        <input type="text" name="date[{$v['id']}][two_jdbs][1]" required value="<?php echo explode(',',$v['two_jdbs'])[1] ?>" placeholder="极对豹顺金额最大范围" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">房间三名称</label>
                                    <div class="layui-input-inline" style='width: 550px;'>
                                        <input type="text" name="date[{$v['id']}][three_room_name]" required value="{$v['three_room_name']}" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">房间三在线人数范围</label>
                                    <div class="layui-input-inline" >
                                        <input type="text" name="date[{$v['id']}][three_zxrs][0]" required value="<?php echo explode(',',$v['three_zxrs'])[0] ?>" placeholder="在线人数最小范围" autocomplete="off" class="layui-input">
                                    </div>
                                    <div class="layui-input-inline">
                                        <input type="text" name="date[{$v['id']}][three_zxrs][1]" required value="<?php echo explode(',',$v['three_zxrs'])[1] ?>" placeholder="在线人数最大范围" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">房间三机器人大小单双投注范围</label>
                                    <div class="layui-input-inline" >
                                        <input type="text" name="date[{$v['id']}][three_dxds][0]" required value="<?php echo explode(',',$v['three_dxds'])[0] ?>" placeholder="大小单双金额最小范围" autocomplete="off" class="layui-input">
                                    </div>
                                    <div class="layui-input-inline">
                                        <input type="text" name="date[{$v['id']}][three_dxds][1]" required value="<?php echo explode(',',$v['three_dxds'])[1] ?>" placeholder="大小单双金额最大范围" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">房间三机器人0-27投注范围</label>
                                    <div class="layui-input-inline" >
                                        <input type="text" name="date[{$v['id']}][three_zesev][0]" required value="<?php echo explode(',',$v['three_zesev'])[0] ?>" placeholder="0-27金额最小范围" autocomplete="off" class="layui-input">
                                    </div>
                                    <div class="layui-input-inline">
                                        <input type="text" name="date[{$v['id']}][three_zesev][1]" required value="<?php echo explode(',',$v['three_zesev'])[1] ?>" placeholder="0-27金额最大范围" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">房间三机器人极对豹顺投注范围</label>
                                    <div class="layui-input-inline" >
                                        <input type="text" name="date[{$v['id']}][three_jdbs][0]" required value="<?php echo explode(',',$v['three_jdbs'])[0] ?>" placeholder="极对豹顺金额最小范围" autocomplete="off" class="layui-input">
                                    </div>
                                    <div class="layui-input-inline">
                                        <input type="text" name="date[{$v['id']}][three_jdbs][1]" required value="<?php echo explode(',',$v['three_jdbs'])[1] ?>" placeholder="极对豹顺金额最大范围" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                                {/if}
                                <div class="layui-form-item">
                                    <label class="layui-form-label">初级游戏介绍</label>
                                    <div class="layui-input-inline" style='width: 550px;'>
                                        <textarea name="date[{$v['id']}][game_js]" placeholder="<br>表示换行" rows="6" cols="70">{$v['game_js']}</textarea>
                                    </div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label">初级游戏资料</label>
                                    <div class="layui-input-inline" style='width: 550px;'>
                                        <textarea name="date[{$v['id']}][game_zl]" placeholder="<br>表示换行" rows="6" cols="70">{$v['game_zl']}</textarea>
                                    </div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label">初级游戏玩法</label>
                                    <div class="layui-input-inline" style='width: 550px;'>
                                        <textarea name="date[{$v['id']}][game_wf]"placeholder="<br>表示换行"  rows="6" cols="70">{$v['game_wf']}</textarea>
                                    </div>
                                </div>
                                {if $v['type']=='pc28' || $v['type']=='jld28' || $v['type']=='jld28'}
                                <div class="layui-form-item">
                                    <label class="layui-form-label">中级游戏介绍</label>
                                    <div class="layui-input-inline" style='width: 550px;'>
                                        <textarea name="date[{$v['id']}][two_game_js]"placeholder="<br>表示换行"  rows="6" cols="70">{$v['two_game_js']}</textarea>
                                    </div>
                                </div>
                                
                                <div class="layui-form-item">
                                    <label class="layui-form-label">中级游戏资料</label>
                                    <div class="layui-input-inline" style='width: 550px;'>
                                        <textarea name="date[{$v['id']}][two_game_zl]" placeholder="<br>表示换行" rows="6" cols="70">{$v['two_game_zl']}</textarea>
                                    </div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label">中级游戏玩法</label>
                                    <div class="layui-input-inline" style='width: 550px;'>
                                        <textarea name="date[{$v['id']}][two_game_wf]" placeholder="<br>表示换行" rows="6" cols="70">{$v['two_game_wf']}</textarea>
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">高级游戏介绍</label>
                                    <div class="layui-input-inline" style='width: 550px;'>
                                        <textarea name="date[{$v['id']}][three_game_js]" placeholder="<br>表示换行" rows="6" cols="70">{$v['three_game_js']}</textarea>
                                    </div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label">高级游戏资料</label>
                                    <div class="layui-input-inline" style='width: 550px;'>
                                        <textarea name="date[{$v['id']}][three_game_zl]" placeholder="<br>表示换行" rows="6" cols="70">{$v['three_game_zl']}</textarea>
                                    </div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label">高级游戏玩法</label>
                                    <div class="layui-input-inline" style='width: 550px;'>
                                        <textarea name="date[{$v['id']}][three_game_wf]" placeholder="<br>表示换行" rows="6" cols="70">{$v['three_game_wf']}</textarea>
                                    </div>
                                </div>
                                {/if}
                                {/if}
                            </div>
                        {/volist}
                        </div>
		
        	            <div class="layui-form-item">
                            <label class="layui-form-label"> </label>
                            <div class="layui-input-inline">
                                <button class="layui-btn" lay-submit lay-filter="fsubmit">设置</button>
                            </div>
                        </div>
                    </div>
                </div>        
            </form>
        </div>
</div>
      
<script>
	//下拉选中时间
	var aa= "{$list['startime']}";
	$(".selector").val(aa);
	
    layui.use(['form'], function () {
        var form = layui.form(), layer = layui.layer;
        //自定义验证规则
        form.verify({
			num: function (value) {
                if(value==''){
                    return '请输入正数';
                }
                if (value < 0) {
                    return '请输入正数';
                } 
            },
			prompt: function (value) {
                if(value==''){
                    return '请输入提示语';
                }
            },
        });
        //改变模式
        form.on('submit(fsubmit)', function(data){
            parent.$.fn.jcb.post('{:url("youxi/index")}',data.field,false);
            return false; 
        });
    });
    $(".quote_1").css("background","#009688");
    function  showCon(id) {
        $("#"+id).show();
        $(".quote_"+id).css("background","#009688");
        for(var i=1;i<7;i++){
            if(id!=i){
                $("#"+i).hide();
                $(".quote_"+i).css("background","#f2f2f2");
            }
        }
    }

</script>

{include file="public/footer" /}