/**
 * 定义默认的语言
 */
const defaultLanguage = localStorage.getItem('i18nextLng') || 'zh';

/**
 * 更新国际化内容
 */
function updateContent() {

  document.querySelectorAll('[data-translate]').forEach(element => {

    const key = element.getAttribute('data-translate');

    element.textContent = i18next.t(key);

  });

  // 更新元素的属性内容，例如 placeholder
  document.querySelectorAll('[data-translate-attr]').forEach(element => {

    const [attr, key] = element.getAttribute('data-translate-attr').split(':');

    element.setAttribute(attr, i18next.t(key));

  });

}
/**
 * 切换语言
 */
function changeLanguage(lng) {

  i18next.changeLanguage(lng, updateContent);

}

/**
 * 动态创建语言选择器
 * 可控制该方法的执行页面，选择性的在不同页面中展示语言切换控件
 */
function createLanguageSelector() {

    const select = document.createElement('select');

    select.setAttribute('onchange', 'changeLanguage(this.value)');

    // 创建语言选项
    const languages = [
        { value: 'en', text: 'English' },
        { value: 'zh', text: '中文' },
        { value: 'vn', text: 'Tiếng Việt' }
    ];

    // 将每个选项添加到 select 中
    languages.forEach(lang => {

        const option = document.createElement('option');

        option.value = lang.value;

        option.textContent = lang.text;

        select.appendChild(option);

    });

    // 设置样式，使其定位到右上角
    select.style.position = 'fixed';

    select.style.top = '10px';

    select.style.right = '10px';

    select.style.zIndex = '1000';

    // 将 select 添加到 body 中
    document.body.appendChild(select);

}
/**
 * 通过国际化key获取对应文本
 */
function getTranslation(key, params = {}) {

  const { store, language } = i18next;

  const translation = store?.data?.[language]?.translation?.[key] ?? key;

  // 如果有参数，则替换模板字符串中的变量
  return Object.keys(params).reduce((translatedString, param) => {

    const regex = new RegExp(`{{${param}}}`, 'g');

    return translatedString.replace(regex, params[param]);

  }, translation);

}
/**
 * 初始化i18n
 */
function initI18next() {
  i18next
  .use(i18nextHttpBackend)
  .use(i18nextBrowserLanguageDetector)
  .init({
    fallbackLng: 'en',
    lng: defaultLanguage,
    backend: {
      loadPath: '/locales/{{lng}}.json'
    },
    detection: {
      // 配置语言检测插件
      order: ['querystring', 'cookie', 'localStorage', 'navigator', 'htmlTag'],
      caches: ['cookie', 'localStorage']
    }
  }, function () {

    i18next.getTranslation = getTranslation;

    updateContent();

    // 更新语言选择器的值，以适配已选择语言
    document.querySelector('select').value = i18next.language;

  });
}

//动态给页面添加国际化的依赖文件
function addScriptsAndExecute(callback) {

  const scripts = [
    "https://unpkg.com/i18next@20.3.1/dist/umd/i18next.min.js",
    "https://cdn.jsdelivr.net/npm/i18next-http-backend/i18nextHttpBackend.min.js",
    "https://unpkg.com/i18next-browser-languagedetector@6.1.2/dist/umd/i18nextBrowserLanguageDetector.min.js"
  ];

  let loadedScripts = 0;

  scripts.forEach(src => {

      const script = document.createElement('script');

      script.src = src;

      script.async = false;

      script.onload = () => {

        // 这里实现所有的js都加载完成后执行init方法
        // 否则i18next对象拿不到
        loadedScripts++;

        if (loadedScripts === scripts.length) callback();

      };

      document.head.appendChild(script);

  });
}

document.addEventListener('DOMContentLoaded', function() {
  setTimeout(() => {
    // 调用方法添加脚本并在所有脚本加载完成后执行回调函数
  addScriptsAndExecute(() => {
    const list = [
      '/index/index/login2.php',
      '/index/user/index.php',
      '/index/index/register.php'
    ]
    // 只在个人中心页面展示选择语言的控件
    if (list.includes(location.pathname)) createLanguageSelector();
  
    initI18next()
  })
  }, 0)
});


