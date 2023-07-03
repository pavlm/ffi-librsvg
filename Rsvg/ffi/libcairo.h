#define FFI_SCOPE "rsvg"
#define FFI_LIB "libcairo.so.2"

typedef uint64_t ulong;

typedef int (*cairo_write_func_t)(void* closure,
					      const unsigned char *data,
					      unsigned int length);

ulong* cairo_image_surface_create (unsigned int format, int width, int height);

ulong* cairo_create(ulong* target);

int cairo_surface_write_to_png(ulong* surface, const char *);

int cairo_surface_write_to_png_stream(ulong* surface,
                                   cairo_write_func_t write_func,
                                   void *closure);

void cairo_destroy(ulong* cr);

void cairo_surface_destroy(ulong* surface);
