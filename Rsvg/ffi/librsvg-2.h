#define FFI_SCOPE "rsvg"
#define FFI_LIB "librsvg-2.so.2"

typedef uint64_t ulong;

typedef struct _RsvgDimensionData {
    int width;
    int height;
    double em;
    double ex;
} RsvgDimensionData;

ulong* rsvg_handle_new_from_file(const char* file, ulong** error);

ulong* rsvg_handle_new_from_data(const char* data, uint64_t data_len, ulong** error);

void rsvg_handle_free(ulong* rsvg);

void rsvg_handle_get_dimensions (ulong* rsvg, RsvgDimensionData* dimension_data);

int rsvg_handle_render_cairo (ulong* rsvg, ulong* cairo);

void rsvg_cleanup(void);
