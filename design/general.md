## Exceptions:
 通过 abort 引发的 HttpException 均会被捕捉且以：
```
{"status": "error", "message": $e->getMessage()}
```
 的形式返回数据。

## Session:
 `global` segment:
 	user.login
 	user.model
