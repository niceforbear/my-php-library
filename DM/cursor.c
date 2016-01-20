// 需要链表却不能使用指针: `游标实现法`
/**
 * 链表中的指针有两个重要特点:
 * 1. 数据存储在一组结构体中,每一个结构体包含有数据以及指向下一个结构体的指针
 * 2. 一个心的结构体可以通过调用malloc而从系统全局内存得到,并可通过free而被释放
 * */

# ifndef _Cursor_H // 链表游标的实现声明

typedef  int PrtToNode;
typedef PtrToNode List;
typedef  PtrToNode Position;

void InitializeCursorSpace( void );

list MakeEmpty(List L);

int IsEmpty(const List L);
int IsLast(const Position P, const List L);
Position Find(ElementType x, const List L);
void Delete(ElementType x, List L);
Position FindPrevious(ElementType x, const List L);
void Insert(ElementType X, List L, Position P);
void DeleteList(List L);
Position Header(const List L);
Position First(const List L);
Position Advance(const Position P);
ElementType Retrieve(const Position P);

# endif     /* _Curesor_H */

/* Place in the implementation file */
struct Node{
    ElementType Element;
    Position Next;
};

struct Node CursorSpace[SpaceSize];

/**
 * 每个list的表头下的第一个元素为0,通过用0代表free(或者为空),将0移走,代表initial
 */

/**
 * Instead of malloc
 */
static Position
CursorAlloc(void){
    Position P;

    P = CursorSpace[0].Next;
    CursorSpace[0].Next = CursorSpace[P].Next;

    return P;
}

/**
 * Instead of free
 */
static void
CursorFree(Position P){
    CursorSpace[P].Next = CursorSpace[0].Next;
    CursorSpace[0].Next = P;
}

/** Return true if L is empty */
int
IsEmpty(List L){
    return CursorSpace[L].Next = 0;
}

int IsLast(Position L, List L){
    return CursorSpace[P].Next == 0;
}

Position
Find(ElementType X, List L){
    Position P;

    P = CursorSpace[l].Next;
    while(P && CursorSpace[P].Element != X)
        P = CursorSpace[P].Next;

    return P;
}

void
Delete(ElementType X, List L){
    Position P, TmpCell;

    P = FindPrevious(X, L);

    if(!IsLast(P, L)){ // Assumption of header use
        TmpCell = CursorSpace[P].Next;
        CursorSpace[P].Next = CursorSpace[TmpCell].Next;
        CursorFree(TmpCell);
    }
}

void
Insert(ElementType X, List L, Position P){
    Position  TmpCell;

    TmpCell = CursorAlloc();
    if(TmpCell == 0){
        FatalError("Out of space!!!");;
    }

    CursorSpace[TmpCell].Element = X;
    CursorSpace[TmpCell].Next = CursorSpace[P].Next;
    CursorSpace[P].Next = TmpCell;
}

