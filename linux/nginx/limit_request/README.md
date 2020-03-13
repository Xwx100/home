## 部署说明
依赖： resty.http

### 1. nginx新增配置：
```text
http {
    ...

    lua_shared_dict req_limit_count_store 10m;

    init_by_lua_block {
        ...
        require "resty.core"
    }
}

```
### 2. 加载 proxy.conf

## 接口使用说明
```text
将请求地址更换为172.16.2.187/proxy 附加header参数：

Ibn-Req-Key：请求限定key；必传
Ibn-Req-Url：目标接口地址；必传
Ibn-Req-Period：请求限定周期，单位：秒；必传
Ibn-Req-Limit：限定周期限定次数； 必传
Ibn-Req-Errmsg：自定义返回信息json结构；非必传，默认：{\"ret\":\"1\",\"msg\":\"%s\",\"content\":[]}
Ibn-Req-Ip：目标接口ip地址；非必传，需要以ip直接访问时传
```
