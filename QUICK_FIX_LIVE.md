# Quick Fix: CSS/JS Not Loading on Live Site

## ⚡ Quick Steps (Do These First)

### 1. Check .env File on Live Server
```env
APP_URL=https://palegoldenrod-lemur-907257.hostingersite.com
```
**NO trailing slash!** ❌ Wrong: `https://...com/` ✅ Right: `https://...com`

### 2. Clear Cache (SSH into live server)
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

### 3. Set Permissions
```bash
chmod -R 755 public
chmod -R 755 storage
```

### 4. Verify Files Are Uploaded
Check these folders exist on live server:
- `public/css/` ✅
- `public/js/` ✅  
- `public/Images/` ✅

### 5. Test Direct Access
Open in browser:
- `https://palegoldenrod-lemur-907257.hostingersite.com/css/style.css`
- If 404, files aren't uploaded or path is wrong

## 🔍 Common Issues

| Issue | Solution |
|-------|----------|
| APP_URL has trailing slash | Remove the `/` |
| Cache not cleared | Run `php artisan optimize:clear` |
| Files not uploaded | Upload `public/` folder contents |
| Document root wrong | Point to `public/` folder in Hostinger |
| HTTPS mixed content | Use `secure_asset()` or set `ASSET_URL` |

## 📝 For Hostinger Specifically

1. **Document Root**: Should point to `public_html/public` (or your public folder)
2. **File Manager**: Upload all files from `public/` folder
3. **.env File**: Edit via File Manager or SSH
4. **PHP Version**: Use PHP 8.1+ (check in Hostinger panel)

## 🚨 Still Not Working?

1. Open browser console (F12)
2. Check Network tab for failed requests
3. Look for 404 errors on CSS/JS files
4. Verify the URLs match your file locations

## ✅ Verification Checklist

- [ ] APP_URL set correctly (no trailing slash)
- [ ] All caches cleared
- [ ] File permissions set (755)
- [ ] All files uploaded to public folder
- [ ] Document root points to public folder
- [ ] Direct file access works (test URL)
- [ ] Browser cache cleared (or use incognito)
